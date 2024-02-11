<?php

namespace App\Imports;

use App\Models\Sinistre;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SinistresImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $day = new \DateTime();

        return new Sinistre([
            'firstname'     => $row['prenom'] ?? "-",
            'lastname'     => $row['nom'] ?? "-",
            'brand'    => $row['marque/type'] ?? "-",
            'matricule' => $row['immatriculation'] ?? "-",
            'contact' => $row['contact'] ?? "-",
            'assurance'     => $row['assurance'] ?? "-",
            'tiers'     => $row['tiers'] ?? "-",
            'date_open' => $row['date_ouverture'] ? Date::excelToDateTimeObject($row['date_ouverture']) : $day->format('Y-m-d'),
            'user_id' => Auth::user()->id,
            'entreprise_id' => Auth::user()->entreprise_id == 0 ? 2 : Auth::user()->entreprise_id,
        ]);
    }
}
