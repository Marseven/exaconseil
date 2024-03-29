<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashflow extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'reason',
        'amount',
        'date_cash',
        'service_id',
        'cashbox_id',
        'entity_id',
        'user_id',
        'entreprise_id',
    ];

    public function cashbox()
    {
        return $this->belongsTo(Cashbox::class);
    }

    public function rubrique()
    {
        return $this->belongsTo(Rubrique::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
