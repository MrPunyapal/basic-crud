@use('App\Enums\FeaturedStatus')

<div class="space-y-8">
    <x-field>
        <x-label for="title">{{ __('posts.form.Title') }}</x-label>
        <x-text-field
            id="title"
            name="title"
            :value="old('title', $post->title ?? null)"
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
        >{{ old('description', $post->description ?? null) }}</x-text-field>
        @error('description')
            <x-error-message>{{ $message }}</x-error-message>
        @enderror
    </x-field>
    <x-field>
        <x-label for="published_at">{{ __('posts.form.Published At') }}</x-label>
        <x-text-field
            id="published_at"
            name="published_at"
            :value="old('published_at', $post->published_at ?? null)"
            type="datetime-local"
        />
        @error('published_at')
            <x-error-message>{{ $message }}</x-error-message>
        @enderror
    </x-field>
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
        @error('category')
            <x-error-message>{{ $message }}</x-error-message>
        @enderror
    </x-field>
    <x-field>
        <x-label>{{ __('posts.form.Is Featured') }}</x-label>
        @foreach (FeaturedStatus::cases() as $featuredStatus)
            <div class="mt-2 flex items-center">
                <input id="is_featured_{{ $featuredStatus->name }}"
                    class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" type="radio"
                    name="is_featured" value="{{ $featuredStatus->value }}" @checked(old('is_featured', $post->is_featured->value ?? null) == $featuredStatus->value)>
                <label for="is_featured_{{ $featuredStatus->name }}"
                    class="ml-2">{{ $featuredStatus->booleanLabel() }}</label>
            </div>
        @endforeach
    </x-field>
    <x-field>
        <x-label for="tags">{{ __('posts.form.Tags') }}</x-label>
        <select class="form-multiselect block w-full" name="tags[]" id="tags" multiple>
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
            <x-error-message>{{ $message }}</x-error-message>
        @enderror
    </x-field>
    <x-field>
        <x-label for="image">{{ __('posts.form.Image') }}</x-label>
        <x-image-field id="image" name="image" :value="$post->image" />
        @error('image')
            <x-error-message>{{ $message }}</x-error-message>
        @enderror
    </x-field>
    <x-field>
        <x-label for="content">{{ __('posts.form.Content') }}</x-label>
        <input id="content" type="hidden" name="content" value="{{ old('content', $post->content ?? null) }}">
        <trix-editor input="content"></trix-editor>
        @error('content')
            <x-error-message>{{ $message }}</x-error-message>
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
