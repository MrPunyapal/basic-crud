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

    /**
     * @return Attribute<string, string>
     */
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ():string => filter_var($this->image, FILTER_VALIDATE_URL) ? $this->image : asset('storage/'.$this->image),
            set: function (string|UploadedFile|null $value): ?string {
                if ($value instanceof UploadedFile) {
                    return $value->store('posts') ?: null;
                }

                return $value;
            }
        );
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
