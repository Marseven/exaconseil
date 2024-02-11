<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devis extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'matricule',
        'contact',
        'number_chassis',
        'user_id',
        'entreprise_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
