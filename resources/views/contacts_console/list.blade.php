@extends('layout.console')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<!-- jQuery (required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<div class="container py-5">

    <!-- Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Contact Submissions</h2>
    </div>

    <!-- Card -->
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="table-responsive">
                <table id="contactsTable" class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($contacts as $contact)
                            <tr>
                                <td class="fw-semibold">{{ $contact->full_name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>
                                    <span class="text-muted">
                                        {{ Str::limit($contact->message, 80) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>
    </div>

</div>

<!-- jQuery + DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#contactsTable').DataTable({
        paging: true,
        searching: true,
        ordering: true,
        order: [[0, "asc"]],
        pageLength: 10,
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search contacts..."
        }
    });
});
</script>

@endsection