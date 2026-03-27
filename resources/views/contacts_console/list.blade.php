@extends('layout.console')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<section class="w3-padding">

    <h2>Contacts Submission</h2>

    <table id="contactsTable" class="w3-table w3-striped w3-margin-top">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contacts as $contact)
                <tr>
                    <td>{{ $contact->full_name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->message }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>

<script>
$(document).ready(function() {
    $('#contactsTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "order": [[0, "asc"]], // default sort by first column (S.No)
        "columnDefs": [
            { "orderable": false, "targets": -1 } // disable sorting on last column (Actions)
        ]
    });
});
</script>

@endsection