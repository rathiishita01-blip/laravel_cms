@extends('layout.console')

@section('content')

<section class="w3-padding">

    <h2>Sections for {{ $page->title }}</h2>

    <a href="/console/pages/sections/{{ $page->id }}/add" class="w3-button w3-green">Add Section</a>

    <table class="w3-table w3-striped w3-margin-top">
        <tr>
            <th>Key</th>
            <th>Title</th>
            <th>Parent</th>
            <th>Type</th>
            <th>Image</th>
            <th>Sort</th>
            <th></th>
        </tr>
        @foreach($sections as $section)
            <tr>
                <td>{{ $section->section_key }}</td>
                <td>{{ $section->title }}</td>
                <td>{{ $section->parent ? $section->parent->title ?? $section->parent->section_key : '-' }}</td>
                <td>{{ $section->type }}</td>
                <td>@if($section->image)<img src="{{ asset('storage/'.$section->image) }}" width="120">@endif</td>
                <td>{{ $section->sort_order }}</td>
                <td>
                    <a href="/console/pages/sections/{{ $page->id }}/edit/{{ $section->id }}">Edit</a>
                    <a href="/console/pages/sections/{{ $page->id }}/delete/{{ $section->id }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </table>

    <a href="/console/pages/list">Back to Pages</a>

</section>

@endsection