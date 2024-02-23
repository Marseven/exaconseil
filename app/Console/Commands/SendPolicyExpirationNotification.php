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
    protected $description = 'Envoyer des emails de notification pour les politiques approchant de leur expiration.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Date actuelle
        $currentDate = Carbon::now();

        $expirationDateLimitMonth = $currentDate->copy()->addMonth();
        $expirationDateLimitTwoWeeks = $currentDate->copy()->addWeeks(2);
        $expirationDateLimitOneWeek = $currentDate->copy()->addWeek();
        $expirationDateLimitTwoDays = $currentDate->copy()->addDays(2);

        $policiesOneMonth = Policy::where('date_expired', '<=', $expirationDateLimitMonth)->get();
        $policiesTwoWeeks = Policy::where('date_expired', '<=', $expirationDateLimitTwoWeeks)->get();
        $policiesOneWeek = Policy::where('date_expired', '<=', $expirationDateLimitOneWeek)->get();
        $policiesTwoDays = Policy::where('date_expired', '<=', $expirationDateLimitTwoDays)->get();

        $admins = User::where('entreprise_id', 2)->get();

        foreach ($admins as $admin) {
            Mail::to('mebodoaristide@gmail.com')->send(new PolicyExpirationMail($policiesTwoWeeks));
            Mail::to('mebodoaristide@gmail.com')->send(new PolicyExpirationMail($policiesOneMonth));
            Mail::to('mebodoaristide@gmail.com')->send(new PolicyExpirationMail($policiesOneWeek));
            Mail::to('mebodoaristide@gmail.com')->send(new PolicyExpirationMail($policiesTwoDays));
        }
    }
}
