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
use Illuminate\Http\UploadedFile;
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

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
            'is_featured' => FeaturedStatus::class,
            'content' => CleanHtmlInput::class,
        ];
    }

    /**
     * @return PostBuilder<Post>
     */
    public function newEloquentBuilder($query): PostBuilder
    {
        return new PostBuilder($query);
    }

    /**
     * @return BelongsTo<Category, Post>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return Attribute<string, string>
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                return filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/'.$value);
            },
            set: function (string|UploadedFile|null $value) {
                if ($value instanceof UploadedFile) {
                    return $value->store('posts', 'public') ?: null;
                }

                return $value;
            }
        );
    }
}
