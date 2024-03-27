<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sinistre extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'brand',
        'matricule',
        'contact',
        'assurance',
        'tiers',
        'date_open',
        'user_id',
        'entreprise_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cashflow()
    {
        return $this->belongsTo(Cashflow::class);
    }
}
