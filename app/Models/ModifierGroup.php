<?php

namespace App\Models;

use App\Models\Concerns\BelongsToTenant;
use Database\Factories\ModifierGroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModifierGroup extends Model
{
    /** @use HasFactory<ModifierGroupFactory> */
    use BelongsToTenant, HasFactory;
}
