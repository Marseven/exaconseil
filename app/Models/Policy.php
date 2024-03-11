<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'matricule',
        'contact',
        'date_begin',
        'date_expired',
        'type',
        'user_id',
        'entreprise_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
