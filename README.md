<div align="center">

# Algoritmia.id Starter CRUD Generator

<img src="https://laravel.com/img/logomark.min.svg" alt="Laravel Logo" width="100" />
<img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" width="100" />
<img src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-social-logo.png" alt="Bootstrap Logo" width="100" />

[![GitHub all releases](https://img.shields.io/github/downloads/anghilmi/starter-crud/total?label=Downloads)](https://github.com/anghilmi/starter-crud/releases)  [![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)

</div>

---
A powerful CRUD generator for Laravel 12 with AdminLTE 3 and Bootstrap 4 integration. Build your application faster with automatic generation of controllers, models, views, and routes.

## Fitur



- **Generate CRUD dari tabel di database** (tanpa/dengan migration).
- **Controller otomatis**: Semua kolom pada tabel dianggap searchable.
- **Model otomatis**: Semua kolom pada tabel dianggap fillable kecuali timestamp.
- **Folder View & Blade CRUD**: Otomatis dibuat sesuai standar Laravel.
- **Route CRUD**: Ditambahkan otomatis.
- **Fitur Delete dengan Modal Bootstrap**: Tampilan modern dan interaktif.
- **Pagination**: Navigasi data menjadi lebih mudah.
- **Search**: Pencarian cepat untuk data.

---

<img src="https://github.com/anghilmi/starter-crud/blob/main/public/algoritmia%20id%20crud.png" alt="screenshot" />

## Cara Pakai

1. **Clone Repository**  
   ```bash
   git clone https://github.com/anghilmi/starter-crud-generator.git
   cd starter-crud-generator
   ```

2. **Buat file `.env` dari template**  
   ```bash
   cp .env.example .env
   ```

3. **Generate Key**  
   ```bash
   php artisan key:generate
   ```

4. **Koneksikan ke Database**  
   - Edit file `.env` untuk menambahkan konfigurasi database.  
   - Gunakan MySQL (contoh: dari XAMPP, Laragon, dsb), atau buat migration sesuai kebutuhan.

5. **Command di Terminal**  
   - **Generate CRUD**:  
     ```bash
     php artisan make:crud ModelName
     ```
     Contoh: `ModelName = Cabang` untuk tabel `cabangs`.
     
   - **Undo/Batalkan CRUD**:  
     ```bash
     php artisan rm:crud ModelName
     ```
     Contoh: `ModelName = Cabang` untuk tabel `cabangs`.

---

## Lokasi File Penting

- **Header dan Sidebar**:  
  `resources\views\layouts\main.blade.php`
  
- **Script Generator CRUD**:  
  `app\Console\Commands\CrudGenerator.php`
  
- **Script Undo CRUD**:  
  `app\Console\Commands\RemoveCrud.php`
  
- **Sumber Daya Dashboard AdminLTE**:  
  `public\adminlte`
  
- **Template Layout dan Kode Program Generator CRUD**:  
  `resources\stubs`

---

## Keep in Touch

<div align="center">
  
  <a href="https://chat.whatsapp.com/FH7MOyMRlLFCClYjrS83pB">
    <img src="https://img.shields.io/badge/WhatsApp-green?logo=whatsapp" alt="Algoritmia WhatsApp Group" />
  </a>
  <a href="#">
    <img src="https://img.shields.io/badge/Telegram-blue?logo=telegram" alt="Telegram" />
  </a>
</div>
