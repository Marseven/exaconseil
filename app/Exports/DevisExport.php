<?php

namespace App\Exports;

use App\Models\Devis;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DevisExport implements FromView
{

    public function view(): View
    {
        $devis = Devis::all();
        return view('admin.devis.export', [
            'devis' => $devis,
        ]);
    }
}
