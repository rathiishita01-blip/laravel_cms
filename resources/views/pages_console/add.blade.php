@extends('layout.console')

@section('content')

<section class="w3-padding">

    <h2>Add Page</h2>

    <form method="post" action="/console/pages/add" novalidate class="w3-margin-bottom">

        @csrf

        <div class="w3-margin-bottom">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}" required>
            @error('title')
                <br><span class="w3-text-red">{{ $message }}</span>
            @enderror
        </div>

        <div class="w3-margin-bottom">
            <label for="slug">Slug:</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" required>
            @error('slug')
                <br><span class="w3-text-red">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="w3-button w3-green">Add Page</button>

    </form>

    <a href="/console/pages/list">Back to Pages</a>

</section>

@endsection