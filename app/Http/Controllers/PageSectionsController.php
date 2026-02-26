<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\PageSectionImage;

class PageSectionsController extends Controller
{
    // List all sections for a page
    public function list(Page $page)
    {
        return view('pages_console.sections.list', [
            'page' => $page,
            'sections' => $page->sections()->orderBy('sort_order')->get(),
        ]);
    }

    // Show add section form
    public function addForm(Page $page)
    {
        return view('pages_console.sections.add', [
            'page' => $page,
        ]);
    }

    // Handle adding a section
    public function add(Page $page)
    {
        $attributes = request()->validate([
            'section_key' => 'required',
            'title' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image',          // Main section image
            'images.*' => 'nullable|image',       // Multiple section images
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:page_sections,id',
        ]);

        // Create main section
        $section = new PageSection();
        $section->page_id = $page->id;
        $section->section_key = $attributes['section_key'];
        $section->title = $attributes['title'] ?? null;
        $section->description = $attributes['description'] ?? null;
        $section->sort_order = $attributes['sort_order'] ?? 0;
        $section->parent_id = $attributes['parent_id'] ?? null;

        // Save main image
        if (request()->hasFile('image')) {
            $section->image = request()->file('image')->store('page_sections');
        }

        $section->save();

        // Save multiple images for the section (not subsections)
        if (request()->hasFile('images')) {
    foreach (request()->file('images') as $file) {
        $path = $file->store('page_sections', 'public');
        $section->images()->create([
            'image' => $path,
        ]);
    }
}

        return redirect("/console/pages/sections/{$page->id}/list")
            ->with('message', 'Section added');
    }

    // Show edit section form
    public function editForm(Page $page, PageSection $section)
    {
        return view('pages_console.sections.edit', [
            'page' => $page,
            'section' => $section,
        ]);
    }

    // Handle editing a section
    public function edit(Page $page, PageSection $section)
    {
        $attributes = request()->validate([
            'section_key' => 'required',
            'title' => 'nullable',
            'description' => 'nullable',
            'image' => 'nullable|image',
            'images.*' => 'nullable|image', // multiple section images
            'sort_order' => 'nullable|integer',
            'parent_id' => 'nullable|exists:page_sections,id',
        ]);

        $section->section_key = $attributes['section_key'];
        $section->title = $attributes['title'] ?? null;
        $section->description = $attributes['description'] ?? null;
        $section->sort_order = $attributes['sort_order'] ?? 0;
        $section->parent_id = $attributes['parent_id'] ?? null;

        // Replace main image if uploaded
        if (request()->hasFile('image')) {
            if ($section->image) { Storage::delete($section->image); }
            $section->image = request()->file('image')->store('page_sections', 'public');
        }

        $section->save();

        // Add new multiple images
        if (request()->hasFile('images')) {
    foreach (request()->file('images') as $file) {
        $path = $file->store('page_sections', 'public');
        $section->images()->create([
            'image' => $path,
        ]);
    }
}

        return redirect("/console/pages/sections/{$page->id}/list")
            ->with('message', 'Section edited');
    }

    // Delete a section (and its images/subsections)
    public function delete(Page $page, PageSection $section)
    {
        // Delete main image
        if ($section->image) { Storage::delete($section->image); }

        // Delete multiple section images
        foreach ($section->images as $img) {
            if ($img->image) { Storage::delete($img->image); }
            $img->delete();
        }

        // Delete subsection content (if any)
        foreach ($section->subsections as $sub) {
            if ($sub->image) { Storage::delete($sub->image); }
            $sub->delete();
        }

        $section->delete();

        return redirect("/console/pages/sections/{$page->id}/list")
            ->with('message', 'Section deleted');
    }
}