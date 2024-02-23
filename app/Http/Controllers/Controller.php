<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    static function format_amount($amount)
    {
        return number_format($amount, 0, ',', ' ');
    }

    static function status($status)
    {
        switch ($status) {
            case 'pending':
                $message['type'] = "primary";
                $message['message'] = "En cours";
                return $message;
                break;
            case 'approved':
                $message['type'] = "success";
                $message['message'] = "Approuvé";
                return $message;
                break;
            case 'rejected':
                $message['type'] = "danger";
                $message['message'] = "Rejetté";
                return $message;
                break;
            case 'blocked':
                $message['type'] = "danger";
                $message['message'] = "Bloqué";
                return $message;
                break;
            case 'missing_file':
                $message['type'] = "danger";
                $message['message'] = "Dossier incomplet";
                return $message;
                break;
            case 'submited':
                $message['type'] = "info";
                $message['message'] = "Soumis";
                return $message;
                break;
            case 'completed':
                $message['type'] = "success";
                $message['message'] = "Approuvé";
                return $message;
                break;
            case 'unpaid':
                $message['type'] = "danger";
                $message['message'] = "Impayée";
                return $message;
                break;
            case 'paid':
                $message['type'] = "success";
                $message['message'] = "Payée";
                return $message;
                break;
            case 'paid_partially':
                $message['type'] = "info";
                $message['message'] = "Payée Partiellement";
                return $message;
                break;
            default:
                $message['type'] = "info";
                $message['message'] = $status;
                return $message;
                break;
        }
    }

    function isBefore($date)
    {
        $dateTime = new DateTime($date);
        $hour = $dateTime->format('H');
        $today = new DateTime('today');

        if ($hour < 18 && $dateTime->format('Y-m-d') === $today->format('Y-m-d')) {
            return true;
        } else {
            return false;
        }
    }

    static function daysBeforeDate($date)
    {
        // Convertir la date en objet Carbon
        $givenDate = Carbon::parse($date);

        // Date actuelle
        $currentDate = Carbon::now();

        // Calculer la différence de jours
        $differenceInDays = $currentDate->diffInDays($givenDate);

        return $differenceInDays;
    }
}
