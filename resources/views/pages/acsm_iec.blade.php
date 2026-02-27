@extends('layout.frontend')

@section('content')

@php
    $grouped = $page->sections->groupBy('section_key');

    function getSection($grouped, $key) {
        return $grouped->get($key, collect())->first();
    }

    function resolveStoragePath($path) {
        if (!$path) return null;
        $disk = \Illuminate\Support\Facades\Storage::disk('public');
        return $disk->exists($path) ? $path : null;
    }
@endphp


{{-- ============================= --}}
{{-- PAGE HEADER --}}
{{-- ============================= --}}
<section class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>{{ $page->title}}</h1>
                <ul class="breadcrumbs">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><img src="{{ asset('assets/images/double-arrow.svg') }}" alt=""></li>
                    <li><a href="#">{{ $page->title}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>


{{-- ============================= --}}
{{-- 1️⃣ LAUNCH VIDEO --}}
{{-- ============================= --}}
@php $launch = getSection($grouped,'launch_video'); @endphp
@if($launch)
<section class="ntpcsection mt-5">
    <div class="container">
        <div class="section-heading text-center mb-4">
            <h2>{{ $launch->title }}</h2>
        </div>

        <div class="row g-4">

            {{-- Local Videos --}}
            @foreach($launch->media->where('type','video') as $video)
                @php $path = resolveStoragePath($video->file_path); @endphp
                @if($path)
                <div class="col-md-6 col-lg-4">
                    <video width="100%" height="300" controls>
                        <source src="{{ asset('storage/'.$path) }}" type="video/mp4">
                    </video>
                </div>
                @endif
            @endforeach

            {{-- YouTube --}}
            @foreach($launch->media->where('type','youtube') as $yt)
                @php
                    preg_match('/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([\w-]+)/', $yt->youtube_url, $m);
                    $id = $m[1] ?? null;
                @endphp
                @if($id)
                <div class="col-md-6 col-lg-4">
                    <iframe width="100%" height="300"
                        src="https://www.youtube.com/embed/{{ $id }}"
                        allowfullscreen></iframe>
                </div>
                @endif
            @endforeach

        </div>
    </div>
</section>
@endif



{{-- ============================= --}}
{{-- 2️⃣ IMAGE SECTIONS --}}
{{-- ============================= --}}
@foreach([
    'poster_banners_wall_stickers',
    'tb_pledge',
    'logo',
    'pledge',
    'promotional_material'
] as $imageKey)

@php $section = getSection($grouped,$imageKey); @endphp

@if($section)
<section class="ntpcsection mt-5">
    <div class="container">

        <div class="section-heading text-center mb-4">
            <h2>{{ $section->title }}</h2>
        </div>

        {{-- IMAGES --}}
@if($section->images->count())
<div class="row g-4">
    @foreach($section->images as $img)
    <div class="col-6 col-md-4 col-lg-3">
        <img src="{{ asset('storage/'.$img->image) }}"
             class="img-fluid rounded shadow">
    </div>
    @endforeach
</div>
@endif


{{-- SPACE BETWEEN IMAGES & PDF --}}
@if($section->images->count() && $section->media->where('type','pdf')->count())
    <div class="my-5"></div>
@endif


{{-- PDFs --}}
@if($section->media->where('type','pdf')->count())
<div class="row g-4">
    @foreach($section->media->where('type','pdf') as $pdf)
    <div class="col-md-4">
        <div class="card shadow-sm p-4 text-center h-100">
            <h6 class="mb-3">Download PDF</h6>

            <a href="{{ asset('storage/'.$pdf->file_path) }}"
               target="_blank"
               class="btn btn-primary btn-sm">
                View / Download
            </a>
        </div>
    </div>
    @endforeach
</div>
@endif

    </div>
</section>
@endif

@endforeach



{{-- ============================= --}}
{{-- 3️⃣ PDF SECTIONS --}}
{{-- ============================= --}}
@foreach([
    'daily_regimen',
    'diet_chart',
    'pamphlets',
    'documentaries',
    'audio_video_clips',
    'awareness_lecture',
    'journal',
    'how_to_enroll'
] as $pdfKey)

@php $section = getSection($grouped,$pdfKey); @endphp

@if($section && $section->media->where('type','pdf')->count())
<section class="ntpcsection mt-5">
    <div class="container">

        <div class="section-heading text-center mb-4">
            <h2>{{ $section->title }}</h2>
        </div>

        <div class="row g-4">
            @foreach($section->media->where('type','pdf') as $pdf)
            <div class="col-md-4">
                <div class="card shadow-sm p-4 text-center h-100">
                    <h6 class="mb-3">{{ $section->title }}</h6>

                    <a href="{{ asset('storage/'.$pdf->file_path) }}"
                       target="_blank"
                       class="btn btn-primary btn-sm">
                        View / Download PDF
                    </a>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

@endforeach


@endsection