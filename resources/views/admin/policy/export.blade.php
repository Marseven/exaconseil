<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom & Prénoms</th>
            <th>Marque</th>
            <th>Matricule</th>
            <th>Contact</th>
            <th>Date de Début</th>
            <th>Date d'Expiration</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($policies as $policy)
            <tr>
                <td>{{ $policy->id }}</td>
                <td>{{ $policy->name ?? '-' }}</td>
                <td>{{ $policy->brand ?? '-' }}</td>
                <td>{{ $policy->matricule ?? '-' }}</td>
                <td>{{ $policy->contact ?? '-' }}</td>
                <td>{{ $policy->date_begin ?? '-' }}</td>
                <td>{{ $policy->date_expired ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
