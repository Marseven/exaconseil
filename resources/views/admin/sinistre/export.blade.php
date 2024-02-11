<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Nom & Prénoms</th>
            <th>Marque</th>
            <th>Matricule</th>
            <th>Contact</th>
            <th>Assurance</th>
            <th>Tiers</th>
            <th>Date d'ouverture</th>
            <th>Date de création</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sinistres as $sinistre)
            <tr>
                <td>{{ $sinistre->id }}</td>
                <td>{{ $sinistre->name }}</td>
                <td>{{ $sinistre->brand }}</td>
                <td>{{ $sinistre->matricule }}</td>
                <td>{{ $sinistre->contact }}</td>
                <td>{{ $sinistre->assurance }}</td>
                <td>{{ $sinistre->tiers }}</td>
                <td>{{ $sinistre->date_open }}</td>
                <td>{{ $sinistre->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
