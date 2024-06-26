<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceEntreprise extends Model
{
    use HasFactory;

    protected $table = 'entreprise_service';

    protected $fillable = [
        'service_id',
        'entreprise_id'
    ];
}
