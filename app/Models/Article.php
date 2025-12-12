<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Fomvasss\MediaLibraryExtension\HasMedia\HasMedia;
use Fomvasss\MediaLibraryExtension\HasMedia\InteractsWithMedia;
use App\Models\Traits\SlugTrait;
use App\Models\Traits\SeoUpdateOrCreate;
use Illuminate\Support\Str;

class Article extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SlugTrait, SeoUpdateOrCreate;
    protected $mediaSingleCollections = ['photo'];
    protected $guarded = ['id'];

    public function registerSeoDefaultTags(): array
    {
        return [
            'title' => $this->name,
            'description' => $this->description,
        ];
    }
}
