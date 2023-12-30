@use('App\Enums\FeaturedStatus')
<div class="grid grid-cols-1 gap-3">
    <label class="block" for="title">
        <span class="text-gray-700">{{ __('posts.form.Title') }}</span>
        <input id="title"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="text" name="title" value="{{ old('title', $post->title ?? null) }}">
        @error('title')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </label>

    <label class="block" for="slug">
        <span class="text-gray-700">{{ __('posts.form.Slug') }}</span>
        <input id="slug"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="text" name="slug" value="{{ old('slug', $post->slug ?? null) }}">
        @error('slug')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </label>

    <label class="block" for="description">
        <span class="text-gray-700">{{ __('posts.form.Description') }}</span>
        <textarea id="description"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            name="description">{{ old('description', $post->description ?? null) }}</textarea>
        @error('description')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </label>

    <label class="block" for="published_at">
        <span class="text-gray-700">{{ __('posts.form.Published At') }}</span>
        <input id="published_at"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at ?? null) }}">
    </label>

    <label class="block" for="category">
        <span class="text-gray-700">{{ __('posts.form.Category') }}</span>
        <select id="category"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            name="category_id">
            <option value="">{{ __('posts.form.Select a Category') }}</option>
            @foreach ($categories as $key => $category)
                <option value="{{ $key }}" @selected(old('category_id', $post->category_id ?? null) == $key)>
                    {{ $category }}</option>
            @endforeach
        </select>
        @error('category')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </label>

    <label class="block">
        <span class="text-gray-700">{{ __('posts.form.Is Featured') }}</span>
        @foreach (FeaturedStatus::cases() as $featuredStatus)
            <div class="mt-2 flex items-center">
                <input id="is_featured_{{ $featuredStatus->name }}"
                    class="form-radio h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" type="radio"
                    name="is_featured" value="{{ $featuredStatus->value }}" @checked(old('is_featured', $post->is_featured->value ?? null) == $featuredStatus->value)>
                <label for="is_featured_{{ $featuredStatus->name }}"
                    class="ml-2">{{ $featuredStatus->booleanLabel() }}</label>
            </div>
        @endforeach
    </label>

    <label class="block" for="tags">
        <span class="text-gray-700">{{ __('posts.form.Tags') }}</span>
        <select class="form-multiselect block w-full mt-1" name="tags[]" id="tags" multiple>
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
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </label>

    <label class="block" for="image">
        <span class="text-gray-700">{{ __('posts.form.Image') }}</span>
        <input
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            id="image"
            name="image"
            type="file"
        >
        @error('image')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </label>

    <div class="mt-2">
        @if (isset($post) && $post->image)
            <img id="image-preview" src="{{ $post->image }}" alt="{{ $post->title }}" width="300">
        @else
            <img
                alt="Image Preview" width="300"
                class="hidden"
                id="image-preview"
            >
        @endif
    </div>

    <label class="block" for="content">
        <span class="text-gray-700">{{ __('posts.form.Content') }}</span>
        <input id="content" type="hidden" name="content" value="{{ old('content', $post->content ?? null) }}">
        <trix-editor input="content"></trix-editor>
        @error('content')
            <div class="text-red-500">{{ $message }}</div>
        @enderror
    </label>
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

        let previewObjectURL = null

        document.querySelector('#image')?.addEventListener('change', (e) => {
            const previewEl = document.querySelector('#image-preview');

            if (previewObjectURL !== null) {
                previewEl.classList.add('hidden')
                URL.revokeObjectURL(previewObjectURL)
            }

            const file = e.target.files[0];

            if (file === undefined) {
                return
            }

            previewObjectURL = URL.createObjectURL(file)

            previewEl.src = previewObjectURL;
            previewEl.classList.remove('hidden');
        })
    </script>
@endpush
