@use('App\Enums\FeaturedStatus')
<div class="grid gap-6 lg:grid-cols-[minmax(0,1.35fr)_minmax(280px,0.65fr)]">
    <section class="rounded-[1.75rem] border border-stone-200 bg-stone-50/70 p-5 sm:p-6">
        <div class="space-y-1">
            <h2 class="text-base font-semibold text-stone-950">Story</h2>
            <p class="text-sm leading-6 text-stone-600">Set the headline, summary, and body copy for this post.</p>
        </div>

        <div class="mt-6 space-y-5">
            <x-field>
                <x-label for="title">{{ __('posts.form.Title') }}</x-label>
                <x-text-field
                    id="title"
                    name="title"
                    :value="old('title', $post->title ?? null)"
                    placeholder="A title worth opening"
                />
                @error('title')
                    <x-error-message>{{ $message }}</x-error-message>
                @enderror
            </x-field>

            <x-field>
                <x-label for="slug">{{ __('posts.form.Slug') }}</x-label>
                <x-text-field
                    id="slug"
                    name="slug"
                    :value="old('slug', $post->slug ?? null)"
                    placeholder="post-slug-url"
                />
                @error('slug')
                    <x-error-message>{{ $message }}</x-error-message>
                @enderror
            </x-field>

            <x-field>
                <x-label for="description">{{ __('posts.form.Description') }}</x-label>
                <x-text-field
                    id="description"
                    multiline
                    name="description"
                    placeholder="A concise description that earns the scroll."
                >{{ old('description', $post->description ?? null) }}</x-text-field>
                @error('description')
                    <x-error-message>{{ $message }}</x-error-message>
                @enderror
            </x-field>

            <x-field>
                <x-label for="content">{{ __('posts.form.Content') }}</x-label>
                <div class="rounded-[1.5rem] border border-stone-300 bg-white p-4 shadow-sm focus-within:border-red-500 focus-within:ring-4 focus-within:ring-red-500/10">
                    <input id="content" type="hidden" name="content" value="{{ old('content', $post->content ?? null) }}">
                    <trix-editor input="content" class="text-base leading-7 text-stone-800"></trix-editor>
                </div>
                @error('content')
                    <x-error-message>{{ $message }}</x-error-message>
                @enderror
            </x-field>
        </div>
    </section>

    <div class="space-y-6">
        <section class="rounded-[1.75rem] border border-stone-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="space-y-1">
                <h2 class="text-base font-semibold text-stone-950">Publishing</h2>
                <p class="text-sm leading-6 text-stone-600">Organize the post and decide how prominently it should appear.</p>
            </div>

            <div class="mt-6 space-y-5">
                <x-field>
                    <x-label for="category_id">{{ __('posts.form.Category') }}</x-label>
                    <x-select id="category_id" name="category_id">
                        <option value="">{{ __('posts.form.Select a Category') }}</option>
                        @foreach ($categories as $key => $category)
                            <option value="{{ $key }}" @selected(old('category_id', $post->category_id ?? null) == $key)>
                                {{ $category }}
                            </option>
                        @endforeach
                    </x-select>
                    @error('category_id')
                        <x-error-message>{{ $message }}</x-error-message>
                    @enderror
                </x-field>

                <x-field>
                    <x-label for="published_at">{{ __('posts.form.Published At') }}</x-label>
                    <x-text-field
                        id="published_at"
                        name="published_at"
                        type="datetime-local"
                        :value="old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : null)"
                    />
                    @error('published_at')
                        <x-error-message>{{ $message }}</x-error-message>
                    @enderror
                </x-field>

                <x-field>
                    <x-label>{{ __('posts.form.Is Featured') }}</x-label>
                    <div class="grid gap-3 sm:grid-cols-2">
                        @foreach (FeaturedStatus::cases() as $featuredStatus)
                            <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-stone-200 bg-stone-50 p-4 transition hover:border-stone-300 hover:bg-white">
                                <input id="is_featured_{{ $featuredStatus->name }}"
                                    class="mt-1 h-4 w-4 border-stone-300 text-red-600 focus:ring-red-500"
                                    type="radio"
                                    name="is_featured"
                                    value="{{ $featuredStatus->value }}"
                                    @checked(old('is_featured', $post->is_featured->value ?? null) == $featuredStatus->value)>
                                <span class="space-y-1">
                                    <span class="block text-sm font-medium text-stone-900">{{ $featuredStatus->label() }}</span>
                                    <span class="block text-sm leading-6 text-stone-500">{{ $featuredStatus->value ? 'Keep this post prominent in the archive and detail view.' : 'Show this post as a standard entry in the archive.' }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </x-field>

                <x-field>
                    <x-label for="tags">{{ __('posts.form.Tags') }}</x-label>
                    <x-select id="tags" name="tags[]" multiple size="8" class="min-h-40">
                        @foreach ($tags as $tag)
                            <option value="{{ $tag }}" @selected(in_array($tag, old('tags', $post->tags ?? [])))>
                                {{ $tag }}
                            </option>
                        @endforeach
                        @foreach (old('tags', $post->tags ?? []) as $tag)
                            @if (!in_array($tag, $tags))
                                <option value="{{ $tag }}" selected>
                                    {{ $tag }}
                                </option>
                            @endif
                        @endforeach
                    </x-select>
                    <p class="text-sm leading-6 text-stone-500">Hold Ctrl or Cmd to select multiple tags.</p>
                    @error('tags')
                        <x-error-message>{{ $message }}</x-error-message>
                    @enderror
                </x-field>
            </div>
        </section>

        <section class="rounded-[1.75rem] border border-stone-200 bg-white p-5 shadow-sm sm:p-6">
            <div class="space-y-1">
                <h2 class="text-base font-semibold text-stone-950">Cover image</h2>
                <p class="text-sm leading-6 text-stone-600">Upload an image that introduces the post without overpowering the copy.</p>
            </div>

            <div class="mt-6">
                <x-image-field id="image" name="image" :value="isset($post) ? $post->image : null" />
            </div>

            @error('image')
                <x-error-message class="mt-2">{{ $message }}</x-error-message>
            @enderror
        </section>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/trix.css') }}" />
@endpush

@push('scripts')
    <script type="text/javascript" charset="utf-8" src="{{ asset('theme/js/trix.umd.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('#title').addEventListener('blur', function() {
                document.querySelector('#slug').value = slugify(this.value);
            });
        });

        function slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/[^\w-]+/g, '') // Remove all non-word chars
                .replace(/--+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, ''); // Trim - from end of text
        }
    </script>
@endpush
