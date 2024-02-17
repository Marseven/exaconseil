<?php

namespace App\Exports;

use App\Models\Sinistre;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SinistresExport implements FromView
{
    protected $begin;
    protected $end;

    public function __construct($begin, $end)
    {
        $this->begin = new \DateTime($begin);
        $this->end = new \DateTime($end);
        $this->end->modify('+1 day');
    }

    public function view(): View
    {
        $sinistres = Sinistre::where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->get();
        return view('admin.sinistre.export', [
            'sinistres' => $sinistres,
        ]);
    }
}
