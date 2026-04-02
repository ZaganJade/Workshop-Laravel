<?php

namespace App\Services;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    /**
     * The Fireworks API Key.
     */
    protected ?string $apiKey;

    /**
     * The model to use (Kimi K2.5 Turbo via Fireworks).
     */
    protected string $model;

    /**
     * The Fireworks API endpoint (OpenAI compatible).
     */
    protected string $endpoint = 'https://api.fireworks.ai/inference/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = config('services.fireworks.key');
        $this->model = config('services.fireworks.model');
    }

    /**
     * Send a prompt to Kimi AI via Fireworks and return the response.
     *
     * @param string $prompt
     * @return string
     */
    public function getResponse(string $prompt): string
    {
        if (empty($this->apiKey) || $this->apiKey === 'your_fireworks_api_key_here') {
            return "Maaf, FIREWORKS_API_KEY belum dikonfigurasi di file .env. Silakan hubungi administrator.";
        }

        try {
            $dbContext = $this->getDatabaseContextText();

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post($this->endpoint, [
                'model' => $this->model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt() . "\n\nDATA AKTUAL DARI DATABASE:\n" . $dbContext
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.3,
                'max_tokens' => 1024,
            ]);

            if ($response->successful()) {
                $result = $response->json();
                return $result['choices'][0]['message']['content'] ?? "Maaf, Kimi tidak bisa memberikan jawaban saat ini.";
            }

            Log::error('Fireworks/Kimi AI API Error', ['response' => $response->body()]);
            return "Maaf, terjadi kesalahan saat menghubungi layanan Kimi AI melalui Fireworks.";

        } catch (\Exception $e) {
            Log::error('Fireworks/Kimi AI Exception', ['message' => $e->getMessage()]);
            return "Maaf, terjadi kesalahan teknis pada sistem AI.";
        }
    }

    /**
     * Fetch relevant data from database to provide context to Kimi.
     */
    protected function getDatabaseContextText(): string
    {
        try {
            // Get Categories
            $categories = Kategori::all()->pluck('nama_kategori')->toArray();
            $categoriesText = !empty($categories) ? implode(", ", $categories) : "Belum ada kategori.";

            // Get Books (Limit to 50 for token efficiency)
            $books = Buku::with('kategori')->limit(50)->get();
            $booksList = [];
            foreach ($books as $buku) {
                $cat = $buku->kategori ? $buku->kategori->nama_kategori : 'N/A';
                $booksList[] = "- {$buku->judul} oleh {$buku->pengarang} (Kategori: {$cat})";
            }
            $booksText = !empty($booksList) ? implode("\n", $booksList) : "Belum ada data buku.";

            // Get Barang
            $items = Barang::all();
            $itemsList = [];
            foreach ($items as $item) {
                $itemsList[] = "- {$item->nama} (Harga: Rp " . number_format($item->harga, 0, ',', '.') . ")";
            }
            $itemsText = !empty($itemsList) ? implode("\n", $itemsList) : "Belum ada data barang.";

            return "DAFTAR KATEGORI:\n{$categoriesText}\n\nDAFTAR BUKU:\n{$booksText}\n\nDAFTAR BARANG:\n{$itemsText}";

        } catch (\Exception $e) {
            Log::error('Error fetching context', ['error' => $e->getMessage()]);
            return "Gagal mengambil data dari database.";
        }
    }

    /**
     * Define the persona and instructions for Kimi.
     */
    protected function getSystemPrompt(): string
    {
        return "Anda adalah 'Kimi AI', asisten cerdas untuk aplikasi Workshop Framework (Manajemen Perpustakaan). 
        Tugas Anda adalah membantu pengguna berdasarkan DATA AKTUAL dari database yang disediakan.
        
        Aturan:
        1. Anda harus sopan, ramah, dan informatif.
        2. Jika ditanya tentang stok buku atau barang, jawablah sesuai DATA AKTUAL yang diberikan.
        3. Jika data tidak ada dalam daftar yang diberikan, beri tahu pengguna bahwa data tersebut tidak tersedia di sistem.
        4. Gunakan format Markdown untuk memberikan jawaban yang rapi.";
    }
}
