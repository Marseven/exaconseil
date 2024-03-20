<?php

namespace App\Imports;

use App\Models\Policy;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PoliciesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $day = new \DateTime();
        if (isset($row['noms']) && isset($row['marque']) && isset($row['contact'])) {
            return new Policy([
                //
                'name'     => $row['noms'] ?? "-",
                'brand'    => $row['marque'] ?? "-",
                'matricule' => $row['immatriculation'] ?? Null,
                'contact' => $row['contact'] ?? "-",
                'date_begin' => isset($row['date_effet']) && is_numeric($row['date_effet']) ? Date::excelToDateTimeObject($row['date_effet']) : Null,
                'date_expired' => isset($row['date_expiration']) && is_numeric($row['date_expiration']) ? Date::excelToDateTimeObject($row['date_expiration'])  : Null,
                'user_id' => Auth::user()->id,
                'entreprise_id' => Auth::user()->entreprise_id == 0 ? 2 : Auth::user()->entreprise_id,
                'type'     => $row['type'] ?? "client",
            ]);
        }
    }
}
