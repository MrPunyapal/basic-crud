<?php

declare(strict_types=1);

namespace App\Models;

use App\Builders\PostBuilder;
use App\Enums\FeaturedStatus;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Mews\Purifier\Casts\CleanHtmlInput;
use Override;

/**
 * @method static PostBuilder<Post> query()
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property UploadedFile|string|null $image
 * @property string $content
 * @property Carbon|null $published_at
 * @property int $category_id
 * @property array<string>|null $tags
 * @property FeaturedStatus $is_featured
 * @property Carbon|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Category $category
 *
 * @mixin Model
 */
#[UseEloquentBuilder(PostBuilder::class)]
final class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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

    // equivalent to the above
    // protected $guarded=[
    //     'id',
    //     'created_at',
    //     'updated_at',
    //     'deleted_at'
    // ];

    // /**
    //  * @param  Builder  $query
    //  * @return PostBuilder<Post>
    //  */
    // #[Override]
    // public function newEloquentBuilder($query): PostBuilder // @pest-ignore-type
    // {
    //     return new PostBuilder($query);
    // }

    /**
     * @return BelongsTo<Category, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return Attribute<string|null, string|null>
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value): ?string {
                if (is_string($value)) {
                    if (filter_var($value, FILTER_VALIDATE_URL)) {
                        return $value;
                    }

                    return Storage::disk('public')->url($value);
                }

                return null;
            },
            set: function (string|UploadedFile|null $value): ?string {
                if ($value instanceof UploadedFile) {
                    return $value->store('posts', 'public') ?: null;
                }

                return $value;
            }
        );
    }

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
}
