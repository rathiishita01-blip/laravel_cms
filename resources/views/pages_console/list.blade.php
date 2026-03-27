@extends('layout.console')

@section('content')

<section class="w3-padding">

    <div class="w3-flex w3-justify-between w3-align-center">
        <h2>Pages</h2>
        <a href="/console/pages/add" class="w3-button w3-green">Add Page</a>
    </div>

    <table class="w3-table w3-striped w3-bordered w3-margin-top datatable">
        <thead>
            <tr>
                <th>Title</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pages as $page)
                <tr>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->slug }}</td>
                    <td>
                        <a class="w3-button w3-small w3-blue" href="/console/pages/edit/{{ $page->id }}">Edit</a>
                        <a class="w3-button w3-small w3-red" href="/console/pages/delete/{{ $page->id }}" onclick="return confirm('Are you sure?')">Delete</a>
                        <a class="w3-button w3-small w3-grey" href="/console/pages/sections/{{ $page->id }}/list">Sections</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.datatable').each(function () {
            new DataTable(this, {
                pageLength: 10,
                responsive: true
            });
        });
    });
</script>
@endpush