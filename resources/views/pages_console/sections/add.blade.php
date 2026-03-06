@extends('layout.console')

@section('content')

<section class="w3-padding">

    <h2>Add Section for {{ $page->title }}</h2>

    <form method="post" action="/console/pages/sections/{{ $page->id }}/add" enctype="multipart/form-data" novalidate class="w3-margin-bottom">

        @csrf

        {{-- Section Key --}}
        <div class="w3-margin-bottom">
            <label for="section_key">Section Key:</label>
            <input type="text" name="section_key" id="section_key" value="{{ old('section_key') }}" required>
            <div class="w3-small">Examples: hero_banner, pm_yojna, roles, moa, aiia, rntcp</div>
            @if($errors->first('section_key'))
                <br><span class="w3-text-red">{{ $errors->first('section_key') }}</span>
            @endif
        </div>

        {{-- Parent Section --}}
        <div class="w3-margin-bottom">
            <label for="parent_id">Parent Section (optional):</label>
            <select name="parent_id" id="parent_id" class="w3-input">
                <option value="">-- None --</option>
                @foreach($page->sections as $section)
                    <option value="{{ $section->id }}" {{ old('parent_id') == $section->id ? 'selected' : '' }}>
                        {{ $section->key ?? $section->section_key }}
                    </option>
                @endforeach
            </select>
            <div class="w3-small">Select a parent section to create a subsection (like PM quote).</div>
        </div>

        {{-- Type --}}
        <div class="w3-margin-bottom">
            <label for="type">Section Type:</label>
            <select name="type" id="type" class="w3-input">
                <option value="single" {{ old('type') == 'single' ? 'selected' : '' }}>Single</option>
                <option value="banner" {{ old('type') == 'banner' ? 'selected' : '' }}>Banner</option>
                <option value="personal" {{ old('type') == 'personal' ? 'selected' : '' }}>Personal</option>
            </select>
        </div>

        {{-- Title --}}
        <div class="w3-margin-bottom">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}">
        </div>

        {{-- Description --}}
        <div class="w3-margin-bottom">
            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
        </div>

        {{-- Single Image --}}
        <div class="w3-margin-bottom">
            <label for="image">Image (optional):</label>
            <input type="file" name="image" id="image">
        </div>

        {{-- Multiple Images --}}
        <div class="w3-margin-bottom">
            <label for="images">Additional Images (multiple)</label>
            <input type="file" name="images[]" id="images" multiple>
        </div>

        <div class="w3-margin-bottom">
            <label for="pdf">Upload PDF (optional)</label>
            <input type="file" name="pdfs[]" multiple>
        </div>

        <div class="w3-margin-bottom">
            <label for="videos">Videos (YouTube embed links, one per line)</label>
            <input type="file" name="videos[]" multiple accept="video/*">
            <textarea name="youtube_links[]" placeholder="YouTube link"></textarea>
        </div>

        <div class="w3-margin-bottom">
            <label>Upload Audio Files</label>
            <input type="file" name="audios[]" multiple>
        </div>


        {{-- Sort Order --}}
        <div class="w3-margin-bottom">
            <label for="sort_order">Sort Order:</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}">
        </div>

        <button type="submit" class="w3-button w3-green">Add Section</button>

    </form>

    <a href="/console/pages/sections/{{ $page->id }}/list">Back to Sections</a>

</section>

@endsection