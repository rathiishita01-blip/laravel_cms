<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PageSectionImage;
use App\Models\PageSectionMedia;

class PageSectionsController extends Controller
{
    // List sections
    public function list(Page $page)
    {
        return view('pages_console.sections.list', [
            'page' => $page,
            'sections' => $page->sections()->with(['images','media','parent'])->orderBy('sort_order')->get(),
        ]);
    }

    // Show add form
    public function addForm(Page $page)
    {
        return view('pages_console.sections.add', [
            'page' => $page,
        ]);
    }

    // Add section
    public function add(Page $page)
    {
        $attributes = request()->validate([
            'section_key' => 'required',
            'title' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'images.*' => 'nullable|image',
            'pdfs.*' => 'nullable|file|mimes:pdf',
            'videos.*' => 'nullable|file|mimes:mp4,mov,avi',
            'youtube_links.*' => 'nullable|url',
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:page_sections,id',
        ]);

        $section = new PageSection();
        $section->page_id = $page->id;
        $section->section_key = $attributes['section_key'];
        $section->title = $attributes['title'] ?? null;
        $section->description = $attributes['description'] ?? null;
        $section->sort_order = $attributes['sort_order'] ?? 0;
        $section->parent_id = $attributes['parent_id'] ?? null;

        if (request()->hasFile('image')) {
            $section->image = request()->file('image')->store('page_sections', 'public');
        }

        $section->save();

        // Multiple images
        if (request()->hasFile('images')) {
            foreach (request()->file('images') as $file) {
                $path = $file->store('page_sections/images', 'public');
                $section->images()->create(['image' => $path]);
            }
        }

        // PDFs
        if (request()->hasFile('pdfs')) {
            foreach (request()->file('pdfs') as $pdf) {
                $path = $pdf->store('page_sections/pdfs', 'public');
                $section->media()->create([
                    'type' => 'pdf',
                    'file_path' => $path
                ]);
            }
        }

        // Local Videos
        if (request()->hasFile('videos')) {
            foreach (request()->file('videos') as $video) {
                $path = $video->store('page_sections/videos', 'public');
                $section->media()->create([
                    'type' => 'video',
                    'file_path' => $path
                ]);
            }
        }

        // Audios
        if (request()->hasFile('audios')) {
            foreach (request()->file('audios') as $audio) {
                $path = $audio->store('page_sections/audios', 'public');
                $section->media()->create([
                    'type' => 'audio',
                    'file_path' => $path
                ]);
            }
        }

        // YouTube
        if (request('youtube_links')) {
            foreach (request('youtube_links') as $link) {
                if ($link) {
                    $section->media()->create([
                        'type' => 'youtube',
                        'youtube_url' => $link
                    ]);
                }
            }
        }

        return redirect("/console/pages/sections/{$page->id}/list")
            ->with('message', 'Section added');
    }

    // Show edit form
    public function editForm(Page $page, PageSection $section)
    {
        return view('pages_console.sections.edit', [
            'page' => $page,
            'section' => $section,
        ]);
    }

    // Edit section
    public function edit(Page $page, PageSection $section)
{
    $attributes = request()->validate([
        'section_key' => 'required',
        'title' => 'nullable',
        'description' => 'nullable',
        'image' => 'nullable|image',
        'images.*' => 'nullable|image',
        'pdfs.*' => 'nullable|file|mimes:pdf',
        'videos.*' => 'nullable|file|mimes:mp4,mov,avi',
        'audios.*' => 'nullable|file|mimes:mp3,wav,ogg,m4a',
        'youtube_links.*' => 'nullable|url',
        'sort_order' => 'nullable|integer',
        'parent_id' => 'nullable|exists:page_sections,id',
    ]);

    // Basic fields update
    $section->section_key = $attributes['section_key'];
    $section->title = $attributes['title'] ?? null;
    $section->description = $attributes['description'] ?? null;
    $section->sort_order = $attributes['sort_order'] ?? 0;
    $section->parent_id = $attributes['parent_id'] ?? null;

    // Replace main image only if new one uploaded
    if (request()->hasFile('image')) {
        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }
        $section->image = request()->file('image')->store('page_sections', 'public');
    }

    $section->save();


    /*
    |--------------------------------------------------------------------------
    | PDFs
    |--------------------------------------------------------------------------
    */

    if (request()->hasFile('pdfs')) {

        // delete only old PDFs
        foreach ($section->media()->where('type', 'pdf')->get() as $media) {
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        }

        // add new PDFs
        foreach (request()->file('pdfs') as $pdf) {
            $path = $pdf->store('page_sections/pdfs', 'public');
            $section->media()->create([
                'type' => 'pdf',
                'file_path' => $path
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Videos
    |--------------------------------------------------------------------------
    */

    if (request()->hasFile('videos')) {

        foreach ($section->media()->where('type', 'video')->get() as $media) {
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        }

        foreach (request()->file('videos') as $video) {
            $path = $video->store('page_sections/videos', 'public');
            $section->media()->create([
                'type' => 'video',
                'file_path' => $path
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Audios
    |--------------------------------------------------------------------------
    */

    if (request()->hasFile('audios')) {

        foreach ($section->media()->where('type', 'audio')->get() as $media) {
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        }

        foreach (request()->file('audios') as $audio) {
            $path = $audio->store('page_sections/audios', 'public');
            $section->media()->create([
                'type' => 'audio',
                'file_path' => $path
            ]);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | YouTube Links
    |--------------------------------------------------------------------------
    */

    if (request('youtube_links')) {

        // delete old youtube links
        foreach ($section->media()->where('type', 'youtube')->get() as $media) {
            $media->delete();
        }

        foreach (request('youtube_links') as $link) {
            if ($link) {
                $section->media()->create([
                    'type' => 'youtube',
                    'youtube_url' => $link
                ]);
            }
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Additional Images (does NOT delete old ones)
    |--------------------------------------------------------------------------
    */

    if (request()->hasFile('images')) {
        foreach (request()->file('images') as $file) {
            $path = $file->store('page_sections/images', 'public');
            $section->images()->create([
                'image' => $path
            ]);
        }
    }

    return redirect("/console/pages/sections/{$page->id}/list")
        ->with('message', 'Section edited successfully');
}

    // Delete section
    public function delete(Page $page, PageSection $section)
    {
        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }

        foreach ($section->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        foreach ($section->media as $media) {
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }
            $media->delete();
        }

        $section->delete();

        return redirect("/console/pages/sections/{$page->id}/list")
            ->with('message', 'Section deleted');
    }

    public function deleteImage(PageSectionImage $image)
    {
        Storage::disk('public')->delete($image->image);
        $image->delete();
        return back()->with('message', 'Image deleted');
    }
}