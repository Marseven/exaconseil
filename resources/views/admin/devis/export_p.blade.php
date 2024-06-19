<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Société / Particlier</th>
            <th>Marque</th>
            <th>Matricule</th>
            <th>Contact</th>
            <th>Date de Début</th>
            <th>Date d'Expiration</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($devis as $devi)
            <tr>
                <td>{{ $devi->id }}</td>
                <td>{{ $devi->name }}</td>
                <td>{{ $devi->brand }}</td>
                <td>{{ $devi->matricule }}</td>
                <td>{{ $devi->contact }}</td>
                <td>{{ $devi->date_begin ?? '-' }}</td>
                <td>{{ $devi->date_expired ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
