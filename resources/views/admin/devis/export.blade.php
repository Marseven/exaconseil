<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Société / Particlier</th>
            <th>Marque</th>
            <th>Matricule</th>
            <th>N° de châssis</th>
            <th>Contact</th>
            <th>Date de création</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($devis as $devi)
            <tr>
                <td>{{ $devi->id }}</td>
                <td>{{ $devi->name }}</td>
                <td>{{ $devi->brand }}</td>
                <td>{{ $devi->matricule }}</td>
                <td>{{ $devi->number_chassis ?? '-' }}</td>
                <td>{{ $devi->contact }}</td>
                <td>{{ $devi->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
