@extends('layout.console')

@section('content')

<section class="w3-padding">

    <h2>Pages</h2>

    <a href="/console/pages/add" class="w3-button w3-green">Add Page</a>

    <table class="w3-table w3-striped w3-margin-top">
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
                        <a href="/console/pages/edit/{{ $page->id }}">Edit</a> |
                        <a href="/console/pages/delete/{{ $page->id }}" onclick="return confirm('Are you sure?')">Delete</a> |
                        <a href="/console/pages/sections/{{ $page->id }}/list">Sections</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>

@endsection