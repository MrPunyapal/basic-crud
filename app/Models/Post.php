<?php

namespace App\Models;

use App\Enums\FeaturedStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'content',
        'published_at',
        'category_id',
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
        'is_featured' => FeaturedStatus::class,
        'content' => CleanHtmlInput::class,
    ];

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value): string => filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/'.$value),
            set: fn (mixed $value): string => filter_var($value, FILTER_VALIDATE_URL) ? $value : $value->store('posts', 'public')
        );
    }

    public function scopeSortBy(Builder $query, string $sortBy, ?string $direction): void
    {
        $direction ??= 'asc';

        $query->orderBy($sortBy, $direction);
    }

    public function scopePublished(Builder $query): void
    {
        $query->where('published_at', '<=', now());
    }

    public function scopeSearch(Builder $query, ?string $search): void
    {
        $query->when($search, function (Builder $query, string $search) {
            $query->where('title', 'like', '%'.$search.'%');
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
