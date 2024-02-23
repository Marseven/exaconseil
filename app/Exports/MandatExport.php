<?php

namespace App\Exports;

use App\Models\Mandat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MandatExport implements FromView
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
        $mandats = Mandat::with('user')->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->get();
        return view('admin.mandat.export', [
            'mandats' => $mandats,
        ]);
    }
}
