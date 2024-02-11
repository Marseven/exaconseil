<?php

namespace App\Exports;

use App\Models\Cashflow;
use Maatwebsite\Excel\Concerns\FromCollection;

class CashflowExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cashflow::all();
    }
}
