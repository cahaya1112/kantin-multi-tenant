<img width="1917" height="1075" alt="Screenshot 2026-08-25 213719" src="https://github.com/user-attachments/assets/6d99e60c-5b27-46ad-831a-bb79bbabed37" />
<img width="1917" height="882" alt="Screenshot 2026-08-25 214427" src="https://github.com/user-attachments/assets/e8bb1af7-54c5-48d8-8d4f-54425a55a4f5" />
<img width="1915" height="1075" alt="Screenshot 2026-08-25 214052" src="https://github.com/user-attachments/assets/412d24bf-f363-4751-a9e2-2420edb13714" />

## Development Database Reset Procedure

> PERINGATAN: Perintah di bawah ini akan MENGHAPUS SELURUH TABEL DAN DATA di database target. Pastikan koneksi yang aktif adalah database DEVELOPMENT (bukan staging/production).

Untuk melakukan reset database dan mengisi ulang data awal (seeder) secara aman dan idempoten:

    php artisan migrate:fresh --seed

Untuk melakukan verifikasi ulang seeder setelah migrasi:

    php artisan db:seed
