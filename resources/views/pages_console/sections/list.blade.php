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
            <th>Main Image</th>
            <th>Additional Images</th>
            <th>PDFs</th>
            <th>Videos</th>
            <th>Sort</th>
            <th>Actions</th>
        </tr>

        @foreach($sections as $section)
            <tr>
                <td>{{ $section->section_key }}</td>
                <td>{{ $section->title }}</td>
                <td>{{ $section->parent ? $section->parent->title ?? $section->parent->section_key : '-' }}</td>
                <td>{{ $section->type }}</td>

                {{-- Main Image --}}
                <td>
                    @if($section->image)
                        <img src="{{ asset('storage/'.$section->image) }}" width="80">
                    @endif
                </td>

                {{-- Additional Images --}}
                <td>
                    @foreach($section->images as $img)
                        <img src="{{ asset('storage/'.$img->image) }}" width="50" style="margin:2px;">
                    @endforeach
                </td>

                {{-- PDFs --}}
                <td>
                    @foreach($section->media->where('type','pdf') as $pdf)
                        <a href="{{ asset('storage/'.$pdf->file_path) }}" target="_blank">PDF</a><br>
                    @endforeach
                </td>

                {{-- Videos --}}
                <td>
                    @foreach($section->media->where('type','video') as $video)
                        <a href="{{ asset('storage/'.$video->file_path) }}" target="_blank">Local Video</a><br>
                    @endforeach

                    @foreach($section->media->where('type','youtube') as $yt)
                        <a href="{{ $yt->youtube_url }}" target="_blank">YouTube</a><br>
                    @endforeach
                </td>

                <td>{{ $section->sort_order }}</td>

                <td>
                    <a href="/console/pages/sections/{{ $page->id }}/edit/{{ $section->id }}">Edit</a> |
                    <a href="/console/pages/sections/{{ $page->id }}/delete/{{ $section->id }}">Delete</a>
                </td>
            </tr>
        @endforeach
    </table>

    <a href="/console/pages/list">Back to Pages</a>

</section>

@endsection