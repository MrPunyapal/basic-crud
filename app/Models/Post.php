<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mews\Purifier\Casts\CleanHtmlInput;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'image',
        'body',
        'published_at',
        'category',
        'tags',
        'is_featured',
    ];

    // protected $guarded=[
    //     'id',
    //     'created_at',
    //     'updated_at',
    //     'deleted_at'
    // ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'body' => CleanHtmlInput::class,
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/' . $value),
            set: fn($value): string => filter_var($value, FILTER_VALIDATE_URL) ? $value : $value->store('posts', 'public')
        );
    }

    public function scopePublished($query): Builder
    {
        return $query->where('published_at', '<=', now());
    }

    public function scopeSearch(Builder $query, string $search = null)
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->where('title', 'like', '%' . $search . '%');
        });
    }
}
