# Security Verification Pertemuan 04

## Tenant Isolation

- [x] Global scope hanya mengembalikan data tenant aktif pada TenantContext.
- [x] Tanpa TenantContext, data tidak difilter oleh scope tenant.
- [x] TenantContext di-reset setelah request/job.
- [x] tenant_id otomatis diisi saat membuat data dalam TenantContext.
- [x] Member hanya dapat melihat menu milik tenant sendiri.
- [x] Scoped binding menolak akses menu tenant lain.
- [x] Policy menolak update menu milik tenant lain.
- [x] Public catalog tidak membocorkan menu dari canteen lain atau tenant inactive.
- [x] Job mengatur dan membersihkan TenantContext untuk setiap tenant.

## Test Result

TenantIsolationTest: 10 passed (17 assertions)

Full test suite: 42 passed (84 assertions)
