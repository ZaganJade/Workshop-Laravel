# Implementation Review: Fireworks AI Chatbot (DB Awareness)

## Project Overview
Integrasi AI Chatbot menggunakan Fireworks AI yang memiliki kemampuan untuk membaca konteks data dari database aplikasi (Buku, Kategori, Barang).

## Tech Stack
- **AI Backend**: Fireworks AI (Llama-3-70B-instruct recommended).
- **Service Layer**: `AiService` (Laravel Service).
- **Data Access**: Eloquent (Buku, Kategori, Barang models).
- **Frontend**: Blade Component + Tailwind CSS 4.

## Core Features
1. **Database Context Injection**: Setiap prompt ke AI akan disisipi data terbaru dari database sebagai "System Prompt".
2. **Markdown Support**: Chatbot mendukung tampilan list dan bold dari AI.
3. **Responsive Design**: Floating widget yang cantik dan responsif di mobile.

## Database Mapping for AI
AI diberikan akses ke data berikut untuk konteks:
- **Tabel Kategori**: Nama-nama kategori buku.
- **Tabel Buku**: Judul, Pengarang, dan Kategori terkait (limit 50).
- **Tabel Barang**: Nama barang dan harga terbaru.

## Security Controls
- **Token Optimization**: Data database diformat dalam teks ringkas untuk menghemat token API.
- **Input Sanitization**: Validasi pesan user maksimal 1000 karakter.
- **Environment Safety**: API Key disimpan di `.env` dan diakses melalui `config/services.php`.

## Maintenance
Untuk memperbarui kepintaran AI atau mengganti model, Anda dapat mengedit nilai `FIREWORKS_MODEL` di file `.env`.
