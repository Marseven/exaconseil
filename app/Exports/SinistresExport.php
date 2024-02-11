<?php

namespace App\Exports;

use App\Models\Sinistre;
use Maatwebsite\Excel\Concerns\FromCollection;

class SinistresExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Sinistre::all();
    }
}
