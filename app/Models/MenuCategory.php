<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\BelongsToTenant;

class MenuCategory extends Model
{
    use BelongsToTenant;

    protected $table = "categories";
    protected $guarded = [];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class, "category_id");
    }
}
