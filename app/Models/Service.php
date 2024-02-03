<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function entreprise()
    {
        return $this->belongsToMany(Entreprise::class, 'service_entreprises', 'service_id', 'entreprise_id');
    }
}
