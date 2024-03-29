<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rubrique extends Model
{
    use HasFactory;

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }
}
