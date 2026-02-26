<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id', 'section_key', 'type', 'parent_id', 'title', 'description', 'image', 'sort_order'
    ];

    public function page() {
        return $this->belongsTo(Page::class);
    }

    // Subsections
    public function subsections() {
        return $this->hasMany(PageSection::class, 'parent_id')->orderBy('sort_order');
    }

    // Parent section
    public function parent() {
        return $this->belongsTo(PageSection::class, 'parent_id');
    }
    public function images() {
        return $this->hasMany(PageSectionImage::class);
    }
}