<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class);
    }
}
