# ADR 0001: Modular Monolith

## Context
Proyek Kantin Multi-Tenant dikerjakan 14 minggu oleh 1 orang/tim kecil.
Kita pakai 1 aplikasi Laravel, 1 database — bukan microservices — biar
sederhana dan transaksi (misal checkout) gampang dijaga konsistensinya.

## Decision
Kode dipecah jadi 6 folder modul di app/Modules/:
- Admin      -> kelola tenant, role, komisi
- Catalog    -> menu, kategori, modifier, stok
- Ordering   -> keranjang, checkout, order
- Payments   -> gateway pembayaran, webhook
- Kitchen    -> status dapur, notifikasi realtime
- Reporting  -> laporan, rekonsiliasi, ekspor

## Consequences
Modul gak boleh manggil controller/service internal modul lain secara
langsung. Kalau butuh komunikasi lintas modul, pakai Event, bukan
manggil class-nya langsung. Contoh: saat Payments menandai order lunas,
Kitchen diberi tahu lewat event, bukan Payments manggil langsung
kode Kitchen.

## Pemetaan Fitur ke Modul

| Fitur                           | Modul     |
|----------------------------------|-----------|
| Login/register                  | Admin     |
| CRUD tenant                     | Admin     |
| Lihat menu tenant                | Catalog   |
| Tambah ke keranjang              | Ordering  |
| Checkout & bayar QRIS            | Payments  |
| Update status pesanan di dapur   | Kitchen   |
| Export laporan penjualan         | Reporting |