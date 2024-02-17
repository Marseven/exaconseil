<?php

namespace App\Exports;

use App\Models\Cashbox;
use App\Models\Cashflow;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class CashflowExport implements FromView
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
        $user = User::find(Auth::user()->id);
        $user->load(['entreprise']);
        if ($user->entreprise_id == 0) {
            $cashflows = Cashflow::with('user', 'cashbox')->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->get();
        } else {
            $cashbox = Cashbox::where('entreprise_id', $user->entreprise_id)->get();
            $cashboxs = [];
            foreach ($cashbox as $cash) {
                $cashboxs[] = $cash->id;
            }
            $cashflows = Cashflow::with('user', 'cashbox')->whereIn('cashbox_id', $cashboxs)->where('created_at', '>=', $this->begin->format('Y-m-d'))->where('created_at', '<=', $this->end->format('Y-m-d'))->get();
        }
        return view('admin.cashflow.export', [
            'cashflows' => $cashflows,
        ]);
    }
}
