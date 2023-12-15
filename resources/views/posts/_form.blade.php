@use('App\Enums\FeaturedStatus')
<div class="form-group mt-2">
    <label for="title">{{ __('posts.form.Title') }}</label>
    <input id="title" class="form-control" type="text" name="title"
        value="{{ old('title', $post->title ?? null) }}">
    @error('title')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mt-2">
    <label for="slug">{{ __('posts.form.Slug') }}</label>
    <input id="slug" class="form-control" type="text" name="slug"
        value="{{ old('slug', $post->slug ?? null) }}">
    @error('slug')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-2">
    <label for="description">{{ __('posts.form.Description') }}</label>
    <textarea id="description" class="form-control" name="description">{{ old('description', $post->description ?? null) }}</textarea>
    @error('description')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-2">
    <label for="published_at">{{ __('posts.form.Published At') }}</label>
    <input id="published_at" class="form-control" type="datetime-local" name="published_at"
        value="{{ old('published_at', $post->published_at ?? null) }}">
</div>

<div class="form-group mt-2">
    <label for="category">{{ __('posts.form.Category') }}</label>
    <select id="category" class="form-control" name="category_id">
        <option value="">{{ __('posts.form.Select a Category') }}</option>
        @foreach ($categories as $key => $category)
            <option value="{{ $key }}" @selected(old('category_id', $post->category_id ?? null) == $key)>
                {{ $category }}</option>
        @endforeach
    </select>
    @error('category')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-2">
    <label for="is_featured">{{ __('posts.form.Is Featured') }}</label>
    @foreach (FeaturedStatus::cases() as $featuredStatus)
        <div class="form-check mt-2">
            <input id="is_featured_{{ $featuredStatus->name }}" class="form-check-input" type="radio"
                name="is_featured" value="{{ $featuredStatus->value }}" @checked(old('is_featured', $post->is_featured->value ?? null) == $featuredStatus->value)>
            <label for="is_featured_{{ $featuredStatus->name }}">{{ $featuredStatus->label() }}</label>
        </div>
    @endforeach
</div>

<div class="form-group mt-2">
    <label for="tags">{{ __('posts.form.Tags') }}</label>
    <select class="form-select" name="tags[]" id="tags" multiple>
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
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-2">
    <label for="image">{{ __('posts.form.Image') }}</label>
    <input id="image" class="form-control" type="file" name="image">
    @error('image')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
    @if (isset($post) && $post->image)
        <div class="mt-2">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" width="300">
        </div>
    @endif
</div>

<div class="form-group mt-2">
    <label for="body">{{ __('posts.form.Body') }}</label>
    <input id="body" type="hidden" name="body" value="{{ old('body', $post->body ?? null) }}">
    <trix-editor input="body"></trix-editor>
    @error('body')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/trix.css') }}">
    <link href="{{ asset('theme/css/select2.min.css') }}" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="{{ asset('theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/js/trix.umd.min.js') }}"></script>
    <script src="{{ asset('theme/js/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#title').on('blur', function() {
                $('#slug').val(slugify($(this).val()));
            });
            $('#tags').select2({
                tags: true,
                maximumSelectionLength: 3
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
