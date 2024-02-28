<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    use HasFactory;

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mandat()
    {
        return $this->belongsTo(Mandat::class);
    }

    public function assurance()
    {
        return $this->belongsTo(Assurance::class);
    }
}
