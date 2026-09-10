<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tenant extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            "is_active" => "boolean",
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "tenant_users")
                    ->withPivot("role_in_tenant")
                    ->withTimestamps();
    }

    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(MenuCategory::class);
    }

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(CommissionScheme::class);
    }
}
