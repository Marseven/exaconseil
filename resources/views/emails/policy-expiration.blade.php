@component('mail::message')
    <h1>Hello {{ config('app.name') }},</h1>

    Ceci est une notification pour vous informer que la police suivante expirera bientôt :

    Nom de la police : {{ $policy->name }}
    Date d'expiration : {{ $policy->date_expired }}

    Cordialment,
    EAC
@endcomponent
