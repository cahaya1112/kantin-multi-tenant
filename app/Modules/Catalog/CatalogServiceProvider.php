<?php

namespace App\Modules\Catalog;

use App\Modules\ModuleServiceProvider;

/**
 * Modul: Catalog (alias `catalog`).
 * Tanggung jawab: Kategori, menu, modifier, stok tenant, dan public catalog (Modul 7).
 */
final class CatalogServiceProvider extends ModuleServiceProvider
{
    public function register(): void
    {
        // Binding kontrak -> implementasi ditambahkan saat modul diimplementasikan.
    }

    protected function moduleAlias(): string
    {
        return 'catalog';
    }
}
