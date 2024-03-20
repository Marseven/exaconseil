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
        if ($row['noms'] && $row['marque'] && $row['contact']) {
            return new Policy([
                //
                'name'     => $row['noms'] ?? "-",
                'brand'    => $row['marque'] ?? "-",
                'matricule' => $row['immatriculation'] ?? "-",
                'contact' => $row['contact'] ?? "-",
                'date_begin' => isset($row['date_effet']) && is_numeric($row['date_effet']) ? Date::excelToDateTimeObject($row['date_effet']) : $day->format('Y-m-d'),
                'date_expired' => isset($row['date_expiration']) && is_numeric($row['date_expiration']) ? Date::excelToDateTimeObject($row['date_expiration'])  : $day->format('Y-m-d'),
                'user_id' => Auth::user()->id,
                'entreprise_id' => Auth::user()->entreprise_id == 0 ? 2 : Auth::user()->entreprise_id,
                'type'     => $row['type'] ?? "client",
            ]);
        }
    }
}
