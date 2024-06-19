<?php

namespace App\Exports;

use App\Models\Policy;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PoliciesExport implements FromView
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
        $policies = Policy::where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->get();
        dd($policies);
        return view('admin.policy.export', [
            'policies' => $policies,
        ]);
    }
}
