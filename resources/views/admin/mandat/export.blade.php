<table>
    <thead>
        <tr>
            <th>#</th>
            <th>N° Mandat</th>
            <th>Assuré</th>
            <th>Tiers</th>
            <th>Véhicule</th>
            <th>Immatriculation</th>
            <th>Agent</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mandats as $mandat)
            <tr>
                <td>{{ $mandat->id }}</td>
                <td>{{ $mandat->number_mandat }}</td>
                <td>{{ $mandat->assure }}</td>
                <td>{{ $mandat->tiers }}</td>
                <td>{{ $mandat->vehicule }}</td>
                <td>{{ $mandat->immatriculation }}</td>
                <td>{{ $mandat->user->lastname . ' ' . $mandat->user->firstname }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
