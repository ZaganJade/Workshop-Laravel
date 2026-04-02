# Implementation Review: Kimi K2.5 Turbo (via Fireworks AI)

## Project Overview
Integrasi AI Chatbot menggunakan model **Kimi K2.5 Turbo** yang dihosting melalui provider **Fireworks AI**. Chatbot tetap terhubung dengan database lokal untuk memberikan jawaban cerdas mengenai data Buku dan Barang.

## Tech Stack & Config
- **Provider**: Fireworks AI (`https://api.fireworks.ai/inference/v1`)
- **Model ID**: `accounts/fireworks/routers/kimi-k2p5-turbo`
- **Auth**: `FIREWORKS_API_KEY` di `.env`.
- **Database Context**: Automatis menyisipkan data dari tabel `buku`, `kategori`, dan `barang`.

## Key Implementation Details
1. **Model Router**: Menggunakan model router Kimi K2.5 dari Fireworks yang dioptimalkan untuk kecepatan dan pemahaman bahasa.
2. **Contextual Awareness**: AI diberikan akses ke 50 buku terbaru dan daftar barang terkini untuk menjawab pertanyaan inventaris.
3. **UI Polish**: Widget chat menampilkan label "Powered by Kimi AI (via Fireworks)" untuk transparansi.

## Security
- API Key dikelola melalui Laravel config (`services.php`).
- Prompt sistem membatasi AI agar hanya menjawab berdasarkan data yang diberikan (grounding).

## Maintenance
Jika ingin mengganti model di masa depan, Anda cukup mengubah nilai `FIREWORKS_MODEL` di file `.env`.
