<?php

namespace App\Modules\Catalog\Services;

use App\Models\Canteen;
use App\Models\Menu;
use Illuminate\Support\Collection;

final class PublicCatalogQuery
{
    /** @return Collection<int, Menu> */
    public function forCanteen(Canteen $canteen): Collection
    {
        return Menu::query()
            ->withoutGlobalScope('tenant')
            ->where('is_available', true)
            ->whereHas('tenant', function ($query) use ($canteen): void {
                $query
                    ->where('canteen_id', $canteen->id)
                    ->where('status', 'active');
            })
            ->orderBy('name')
            ->get();
    }
}
