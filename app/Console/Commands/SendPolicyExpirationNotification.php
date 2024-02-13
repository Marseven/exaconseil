<?php

namespace App\Console\Commands;

use App\Mail\PolicyExpirationMail;
use Illuminate\Console\Command;
use App\Models\Policy;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendPolicyExpirationNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'policy:expiration-notification';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notification emails for policies approaching expiration';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Récupérer la valeur du délai de notification depuis les paramètres
        $notificationDays = (int) config('settings.date_notification');

        // Calculer la date d'expiration limite
        $expirationDateLimit = Carbon::now()->addDays($notificationDays);

        // Récupérer toutes les politiques qui expirent dans la limite de notification
        $policies = Policy::where('date_expired', '<=', $expirationDateLimit)->get();

        foreach ($policies as $policy) {
            // Récupérer les administrateurs associés à cette politique
            $admins = $policy->admins;

            // Envoyer un e-mail de notification à chaque administrateur
            foreach ($admins as $admin) {
                Mail::to($admin->email)->send(new PolicyExpirationMail($policy));
            }
        }
    }
}
