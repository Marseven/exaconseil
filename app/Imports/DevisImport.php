<?php

namespace App\Imports;

use App\Models\Devis;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DevisImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $day = new \DateTime();
        return new Devis([
            //
            'name'     => $row['noms'] ?? "-",
            'brand'    => $row['marque'] ?? "-",
            'matricule' => $row['immatriculation'] ?? "-",
            'contact' => $row['contact'] ?? "-",
            'number_chassis' => $row['numero_chassis'] ?? "-",
            'user_id' => Auth::user()->id,
            'entreprise_id' => Auth::user()->entreprise_id == 0 ? 2 : Auth::user()->entreprise_id,
        ]);
    }
}
