<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Type</th>
            <th>Raison / Motif</th>
            <th>Montant</th>
            <th>Date</th>
            <th>Caisse</th>
            <th>Agent</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cashflows as $cashflow)
            <tr>
                <td>{{ $cashflow->id }}</td>
                <td>{{ $cashflow->type }}</td>
                <td>{{ $cashflow->reason }}</td>
                <td>{{ $cashflow->amount }}</td>
                <td>{{ $cashflow->date_cash }}</td>
                <td>{{ $cashflow->cashbox->name }}</td>
                <td>{{ $cashflow->user->firstname . ' ' . $cashflow->user->lastname }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
