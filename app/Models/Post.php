<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\PostBuilder;
use App\Enums\FeaturedStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mews\Purifier\Casts\CleanHtmlInput;

/**
 * @method static PostBuilder query()
 */
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

    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    public function image(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value): string => filter_var($value, FILTER_VALIDATE_URL) ? $value.'' : asset('storage/'.$value),
            set: fn (mixed $value): string => ($value instanceof \Illuminate\Http\UploadedFile ? $value->store('posts') : $value).'',
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
