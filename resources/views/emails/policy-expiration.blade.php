@component('mail::message')
    <h1>Bonjour,</h1>

    Ceci est une notification pour vous informer que les polices suivante expireront bientôt :

    @foreach ($policies as $policy)
        <ul>
            <li>{{ $policy->name }}</li>
        </ul>
    @endforeach
    @if ($policies->count() > 0)
        Nombre de jour restant : {{ App\Http\Controllers\Controller::daysBeforeDate($policies->first()->date_expired) }}
        Date d'expiration : {{ $policies->first()->date_expired }}
    @endif
    Cordialment,
    Entreprise d'Intermédiation en Assurance
@endcomponent
