<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DiningTable extends Model
{
    protected $table = "tables";
    protected $guarded = [];

    public function canteen(): BelongsTo
    {
        return $this->belongsTo(Canteen::class);
    }
}
