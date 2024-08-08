<?php

declare(strict_types=1);

namespace App\Models;

use Override;
use App\Builders\PostBuilder;
use App\Enums\FeaturedStatus;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Mews\Purifier\Casts\CleanHtmlInput;

/**
 * @method static PostBuilder query()
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property UploadedFile|string|null $image
 * @property array $content
 * @property Carbon|null $published_at
 * @property int $category_id
 * @property array|null $tags
 * @property FeaturedStatus $is_featured
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 *
 * @mixin Model
 */
class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory;

    use SoftDeletes;

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

    /**
     * @param  Builder  $query
     * @return PostBuilder<Post>
     */
    #[Override]
    public function newEloquentBuilder($query): PostBuilder // @pest-ignore-type
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

    //equivalent to the above
    // protected $guarded=[
    //     'id',
    //     'created_at',
    //     'updated_at',
    //     'deleted_at'
    // ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    #[Override]
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
     * @return Attribute<mixed, mixed>
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value): mixed => filter_var($value, FILTER_VALIDATE_URL) ? $value : asset('storage/'.$value),
            set: function (string|UploadedFile|null $value): mixed {
                if ($value instanceof UploadedFile) {
                    return $value->store('posts', 'public') ?: null;
                }

                return $value;
            }
        );
    }
}
