# Demo Script Pertemuan 04

## 1. Tenant Context
- Login sebagai user yang menjadi anggota tenant.
- Akses route tenant menggunakan slug tenant.
- Pastikan TenantContext terisi selama request.

## 2. Tenant Isolation
- Buka daftar menu tenant sendiri.
- Pastikan hanya menu tenant tersebut yang tampil.
- Coba akses menu milik tenant lain.
- Pastikan akses ditolak dengan 404.

## 3. Policy
- Uji perubahan status menu milik tenant sendiri.
- Pastikan perubahan berhasil.
- Uji perubahan menu milik tenant lain.
- Pastikan policy menolak akses.

## 4. Public Catalog
- Ambil katalog berdasarkan canteen.
- Pastikan hanya menu tenant aktif dari canteen tersebut yang ditampilkan.
- Pastikan menu dari canteen lain dan tenant inactive tidak ikut tampil.

## 5. Job Context
- Jalankan CountTenantMenus untuk tenant A.
- Pastikan jumlah menu sesuai tenant A.
- Pastikan TenantContext dibersihkan setelah job.
- Jalankan kembali untuk tenant B dan pastikan hasil sesuai tenant B.

## 6. Verification
- Jalankan TenantIsolationTest.
- Jalankan full test suite.
- Jalankan route list, Pint, dan npm build sebagai quality gate.
