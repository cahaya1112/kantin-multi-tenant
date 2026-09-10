# Data Dictionary & Schema Mapping

## Baseline Adjustments

| Nama Tabel Physical | Nama Model Eloquent | Penyesuaian Constraint & Schema |
| :--- | :--- | :--- |
| tables | DiningTable | Mapping $table = "tables". Unique constraint (canteen_id, table_number). |
| categories | MenuCategory | Mapping $table = "categories". Menggunakan trait BelongsToTenant. |
| menu_modifiers | ModifierGroup | Mapping $table = "menu_modifiers". Relasi ke menus dan tenants. |
| tenant_commissions | CommissionScheme | Mapping $table = "tenant_commissions". Relasi ke tenants. |
| sessions | - | Ditambahkan untuk SESSION_DRIVER=database. |

