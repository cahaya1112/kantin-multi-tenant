# Dokumentasi Arsitektur & Konvensi Sistem

Dokumen ini mendokumentasikan aturan dependensi, konvensi rute, namespace, serta struktur komponen UI pada aplikasi Kantin Multi-Tenant. Tujuan dokumen ini adalah memastikan struktur *Modular Monolith* tetap teratur, terisolasi, dan mudah dirawat seiring pertumbuhan aplikasi.

---

## 1. Aturan Dependensi (Dependency Rules)

Aplikasi ini menggunakan pendekatan **Modular Monolith**. Setiap modul domain mengisolasi logika bisnisnya sendiri untuk mencegah ketergantungan erat (*tight coupling*).

### Diagram Dependensi

```mermaid
graph TD
    UI["App / UI Shells"]
    
    Admin["Modules/Admin"]
    Ordering["Modules/Ordering"]
    Payments["Modules/Payments"]
    Reporting["Modules/Reporting"]
    
    Core["Modules/Core & App/Models"]

    UI --> Admin
    UI --> Ordering
    UI --> Payments
    UI --> Reporting

    Admin --> Core
    Ordering --> Core
    Payments --> Core
    Reporting --> Core