@use('App\Enums\FeaturedStatus')
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Left Column -->
    <div class="space-y-6">
        <!-- Title Field -->
        <x-field>
            <x-label for="title" class="flex items-center space-x-2 text-slate-700 font-medium">
                <i class="fas fa-heading text-blue-500"></i>
                <span>{{ __('posts.form.Title') }}</span>
            </x-label>
            <x-text-field
                id="title"
                name="title"
                :value="old('title', $post->title ?? null)"
                class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/70 backdrop-blur-sm"
                placeholder="Enter post title..."
            />
            @error('title')
                <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
            @enderror
        </x-field>

        <!-- Slug Field -->
        <x-field>
            <x-label for="slug" class="flex items-center space-x-2 text-slate-700 font-medium">
                <i class="fas fa-link text-green-500"></i>
                <span>{{ __('posts.form.Slug') }}</span>
            </x-label>
            <x-text-field
                id="slug"
                name="slug"
                :value="old('slug', $post->slug ?? null)"
                class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/70 backdrop-blur-sm"
                placeholder="post-slug-url"
            />
            @error('slug')
                <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
            @enderror
        </x-field>

        <!-- Category Field -->
        <x-field>
            <x-label for="category_id" class="flex items-center space-x-2 text-slate-700 font-medium">
                <i class="fas fa-tag text-purple-500"></i>
                <span>{{ __('posts.form.Category') }}</span>
            </x-label>
            <x-select id="category_id" name="category_id" class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/70 backdrop-blur-sm">
                <option value="">{{ __('posts.form.Select a Category') }}</option>
                @foreach ($categories as $key => $category)
                    <option value="{{ $key }}" @selected(old('category_id', $post->category_id ?? null) == $key)>
                        {{ $category }}
                    </option>
                @endforeach
            </x-select>
            @error('category')
                <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
            @enderror
        </x-field>

        <!-- Published At Field -->
        <x-field>
            <x-label for="published_at" class="flex items-center space-x-2 text-slate-700 font-medium">
                <i class="fas fa-calendar-alt text-indigo-500"></i>
                <span>{{ __('posts.form.Published At') }}</span>
            </x-label>
            <x-text-field
                id="published_at"
                name="published_at"
                :value="old('published_at', $post->published_at ?? null)"
                type="datetime-local"
                class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/70 backdrop-blur-sm"
            />
            @error('published_at')
                <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
            @enderror
        </x-field>
    </div>

    <!-- Right Column -->
    <div class="space-y-6">
        <!-- Featured Status -->
        <x-field>
            <x-label class="flex items-center space-x-2 text-slate-700 font-medium mb-3">
                <i class="fas fa-star text-yellow-500"></i>
                <span>{{ __('posts.form.Is Featured') }}</span>
            </x-label>
            <div class="space-y-3">
                @foreach (FeaturedStatus::cases() as $featuredStatus)
                    <label class="flex items-center p-3 rounded-xl border border-slate-200 hover:bg-blue-50/50 transition-colors duration-200 cursor-pointer">
                        <input id="is_featured_{{ $featuredStatus->name }}"
                            class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500 focus:ring-2"
                            type="radio"
                            name="is_featured"
                            value="{{ $featuredStatus->value }}"
                            @checked(old('is_featured', $post->is_featured->value ?? null) == $featuredStatus->value)>
                        <span class="ml-3 text-slate-700">{{ $featuredStatus->booleanLabel() }}</span>
                    </label>
                @endforeach
            </div>
        </x-field>

        <!-- Tags Field -->
        <x-field>
            <x-label for="tags" class="flex items-center space-x-2 text-slate-700 font-medium">
                <i class="fas fa-tags text-pink-500"></i>
                <span>{{ __('posts.form.Tags') }}</span>
            </x-label>
            <select class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/70 backdrop-blur-sm" name="tags[]" id="tags" multiple>
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
            </select>
            @error('tags')
                <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
            @enderror
        </x-field>

        <!-- Image Field -->
        <x-field>
            <x-label for="image" class="flex items-center space-x-2 text-slate-700 font-medium">
                <i class="fas fa-image text-teal-500"></i>
                <span>{{ __('posts.form.Image') }}</span>
            </x-label>
            <div class="mt-2">
                <x-image-field id="image" name="image" :value="isset($post) ? $post->image : null" />
            </div>
            @error('image')
                <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
            @enderror
        </x-field>
    </div>
</div>

<!-- Full Width Fields -->
<div class="space-y-6 mt-8">
    <!-- Description Field -->
    <x-field>
        <x-label for="description" class="flex items-center space-x-2 text-slate-700 font-medium">
            <i class="fas fa-align-left text-orange-500"></i>
            <span>{{ __('posts.form.Description') }}</span>
        </x-label>
        <x-text-field
            id="description"
            multiline
            name="description"
            class="mt-2 w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/70 backdrop-blur-sm min-h-[100px]"
            placeholder="Brief description of your post..."
        >{{ old('description', $post->description ?? null) }}</x-text-field>
        @error('description')
            <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
        @enderror
    </x-field>

    <!-- Content Field -->
    <x-field>
        <x-label for="content" class="flex items-center space-x-2 text-slate-700 font-medium">
            <i class="fas fa-edit text-cyan-500"></i>
            <span>{{ __('posts.form.Content') }}</span>
        </x-label>
        <div class="mt-2 rounded-xl overflow-hidden border border-slate-200 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-200 transition-all duration-200">
            <input id="content" type="hidden" name="content" value="{{ old('content', $post->content ?? null) }}">
            <trix-editor input="content" class="bg-white/70 backdrop-blur-sm"></trix-editor>
        </div>
        @error('content')
            <x-error-message class="mt-1 text-red-500 text-sm">{{ $message }}</x-error-message>
        @enderror
    </x-field>
</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/trix.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/tom-select.css') }}" />
@endpush

@push('scripts')
    <script type="text/javascript" charset="utf-8" src="{{ asset('theme/js/trix.umd.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8" src="{{ asset('theme/js/tom-select.complete.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('#title').addEventListener('blur', function() {
                document.querySelector('#slug').value = slugify(this.value);
            });

            new TomSelect('#tags', {
                create: true,
                plugins: {
                    remove_button: {
                        title: 'Remove tag'
                    }
                }
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
