<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'business_sector',
        'email',
        'phone',
        'address',
        'photo',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_entreprises', 'service_id', 'entreprise_id');
    }
}
