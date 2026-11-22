# Lab8Web – Praktikum 8: PHP dan Database MySQL

Nama: Fauzan Dwi Nur Hafizh  
NIM: 312510180  
Kelas:I253A
Mata Kuliah: Pemrograman Web OBE

## Tujuan
1. Memahami konsep dasar database.
2. Memahami konsep dasar CRUD menggunakan PHP.
3. Membuat program CRUD sederhana menggunakan PHP dan MySQL.

> CRUD = **C**reate (tambah), **R**ead (tampil), **U**pdate (ubah), **D**elete (hapus).

---

## Langkah 1 – Menjalankan MySQL Server
Buka **XAMPP Control Panel**, klik **Start** pada modul **Apache** dan **MySQL** sampai statusnya hijau.
Apache adalah web server (menjalankan file PHP), MySQL adalah database server (menyimpan data).

![XAMPP](screenshots/01_xampp.png)

## Langkah 2 – Membuka phpMyAdmin
Buka browser, akses `http://localhost/phpmyadmin/`. phpMyAdmin adalah aplikasi web untuk mengelola MySQL.

![phpMyAdmin](screenshots/02_phpmyadmin.png)

## Langkah 3 – Membuat Database
Pada tab **SQL** jalankan:
```sql
CREATE DATABASE latihan1;
```
Perintah ini membuat database bernama `latihan1`.

![Database](screenshots/03_database.png)

## Langkah 4 – Membuat Tabel `data_barang`
Pilih database `latihan1`, tab **SQL**, jalankan:
```sql
CREATE TABLE data_barang (
  id_barang  int(10) auto_increment PRIMARY KEY,
  kategori   varchar(30),
  nama       varchar(50),
  gambar     varchar(100),
  harga_beli decimal(10,0),
  harga_jual decimal(10,0),
  stok       int(4)
);
```
`id_barang` adalah primary key yang naik otomatis (auto_increment) sehingga setiap barang punya ID unik.

![Tabel](screenshots/04_tabel.png)

## Langkah 5 – Mengisi Data Awal
```sql
INSERT INTO data_barang (kategori, nama, gambar, harga_beli, harga_jual, stok)
VALUES ('Elektronik', 'HP Samsung Android', 'hp_samsung.jpg', 2000000, 2400000, 5),
       ('Elektronik', 'HP Xiaomi Android',  'hp_xiaomi.jpg',  1000000, 1400000, 5),
       ('Elektronik', 'HP OPPO Android',    'hp_oppo.jpg',    1800000, 2300000, 5);
```
Cek dengan `SELECT * FROM data_barang;`

![Data](screenshots/05_data.png)

## Langkah 6 – Membuat Folder Proyek
Buat folder `lab8_php_database` di `C:\xampp\htdocs\` (atau `D:\xampp\htdocs\`), lalu buat subfolder `gambar` untuk menyimpan gambar barang.
Akses lewat `http://localhost/lab8_php_database/`.

![Folder](screenshots/06_folder.png)

## Langkah 7 – File `koneksi.php`
Berisi pengaturan koneksi (`host`, `user`, `pass`, `db`) dan fungsi `mysqli_connect()`. Jika gagal, tampil pesan error dan program berhenti (`die()`).
Untuk menguji, hapus tanda `#` pada `#else echo "Koneksi berhasil";`, buka `koneksi.php` di browser, lalu kembalikan lagi.

![Koneksi](screenshots/07_koneksi.png)

## Langkah 8 – `index.php` (Read)
- `include("koneksi.php")` memanggil koneksi.
- `SELECT * FROM data_barang` mengambil semua data.
- `while (mysqli_fetch_array(...))` mengulang setiap baris menjadi baris tabel HTML.
- Kolom **Aksi** berisi link **Ubah** dan **Hapus**, serta ada link **Tambah Barang**.

![Index](screenshots/08_index.png)

## Langkah 9 – `tambah.php` (Create)
- Form memakai `method="post"` dan `enctype="multipart/form-data"` (wajib untuk upload file).
- Setelah tombol Simpan ditekan, data dibaca dari `$_POST`, gambar dari `$_FILES`.
- Gambar dipindah ke folder `gambar/` dengan `move_uploaded_file()`.
- Data disimpan dengan `INSERT INTO`, lalu halaman dialihkan ke `index.php`.

![Tambah](screenshots/09_tambah.png)
![Hasil tambah](screenshots/09b_hasil_tambah.png)

## Langkah 10 – `ubah.php` (Update)
- Link Ubah mengirim ID lewat URL (`ubah.php?id=1`), dibaca dengan `$_GET['id']`.
- Data lama diambil dengan `SELECT ... WHERE id_barang = ?` lalu diisi ke form.
- Saat Simpan, `UPDATE ... WHERE id_barang = ?` dijalankan. Jika tidak memilih gambar baru, gambar lama dipertahankan.
- ID dikirim lewat `<input type="hidden">`.

![Ubah](screenshots/10_ubah.png)
![Hasil ubah](screenshots/10b_hasil_ubah.png)

## Langkah 11 – `hapus.php` (Delete)
Membaca `id` dari URL, menjalankan `DELETE FROM data_barang WHERE id_barang = ?`, lalu kembali ke `index.php`. Di `index.php` ada konfirmasi `confirm()` sebelum menghapus.

![Hapus](screenshots/11_hapus.png)

---

## Perbaikan dari Modul (catatan)
Kode pada modul memiliki beberapa kesalahan kecil yang diperbaiki di sini:

| Masalah di modul | Perbaikan |
|---|---|
| `enctype="multipart/formdata"` di ubah.php (salah ketik) | `multipart/form-data` |
| `is_select('Komputer', ...)` dipakai untuk semua opsi kategori | Setiap opsi dibandingkan dengan nilainya sendiri |
| Urutan kolom Harga Jual/Beli terbalik di tabel index | Header dan data disesuaikan |
| Kolom Aksi menampilkan ID, tanpa link Ubah/Hapus/Tambah | Ditambahkan link Tambah, Ubah, Hapus |
| Path gambar dobel (`gambar/gambar/...`) | DB menyimpan nama file saja |
| Query dirangkai langsung dari input (rawan SQL Injection) | Memakai *prepared statement* |
| Ukuran kolom `nama` 30 vs 50 | Disamakan 50 |

## Cara Menjalankan
1. Jalankan Apache dan MySQL di XAMPP.
2. Import `lab8_php_database/database.sql` lewat phpMyAdmin.
3. Salin folder `lab8_php_database` ke `htdocs`.
4. Buka `http://localhost/lab8_php_database/`.
