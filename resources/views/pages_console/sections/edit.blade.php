@extends('layout.console')

@section('content')

<section class="w3-padding">

    <h2>Edit Section for {{ $page->title }}</h2>

    <form method="post" action="/console/pages/sections/{{ $page->id }}/edit/{{ $section->id }}" enctype="multipart/form-data" novalidate class="w3-margin-bottom">

        @csrf

        {{-- Section Key --}}
        <div class="w3-margin-bottom">
            <label for="section_key">Section Key:</label>
            <input type="text" name="section_key" id="section_key" value="{{ old('section_key', $section->section_key) }}" required>
            <div class="w3-small">Examples: hero_banner, pm_yojna, roles, moa, aiia, rntcp</div>
        </div>

        {{-- Parent Section --}}
        <div class="w3-margin-bottom">
            <label for="parent_id">Parent Section (optional):</label>
            <select name="parent_id" id="parent_id" class="w3-input">
                <option value="">-- None --</option>
                @foreach($page->sections as $s)
                    <option value="{{ $s->id }}" {{ old('parent_id', $section->parent_id) == $s->id ? 'selected' : '' }}>
                        {{ $s->key ?? $s->section_key }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Type --}}
        <div class="w3-margin-bottom">
            <label for="type">Section Type:</label>
            <select name="type" id="type" class="w3-input">
                <option value="single" {{ old('type', $section->type) == 'single' ? 'selected' : '' }}>Single</option>
                <option value="banner" {{ old('type', $section->type) == 'banner' ? 'selected' : '' }}>Banner</option>
                <option value="personal" {{ old('type', $section->type) == 'personal' ? 'selected' : '' }}>Personal</option>
            </select>
        </div>

        {{-- Title --}}
        <div class="w3-margin-bottom">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title', $section->title) }}">
        </div>

        {{-- Description --}}
        <div class="w3-margin-bottom">
            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ old('description', $section->description) }}</textarea>
        </div>

        {{-- Image --}}
        <div class="w3-margin-bottom">
            <label for="image">Image (optional):</label>
            @if($section->image)
                <div><img src="{{ asset('storage/'.$section->image) }}" width="240"></div>
            @endif
            <input type="file" name="image" id="image">
        </div>

        {{-- Multiple Images --}}
        <div class="w3-margin-bottom">
            <label for="images">Additional Images (optional, multiple allowed):</label>
            <input type="file" name="images[]" id="images" multiple>
        </div>

        {{-- Sort Order --}}
        <div class="w3-margin-bottom">
            <label for="sort_order">Sort Order:</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $section->sort_order) }}">
        </div>

        <button type="submit" class="w3-button w3-green">Edit Section</button>

    </form>

    <a href="/console/pages/sections/{{ $page->id }}/list">Back to Sections</a>

</section>

@endsection