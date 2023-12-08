<div class="form-group mt-2">
    <label for="title">Title</label>
    <input id="title" class="form-control" type="text" name="title"
        value="{{ old('title', $post->title ?? null) }}">
    @error('title')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>
<div class="form-group mt-2">
    <label for="slug">Slug</label>
    <input id="slug" class="form-control" type="text" name="slug"
        value="{{ old('slug', $post->slug ?? null) }}">
    @error('slug')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-2">
    <label for="description">Description</label>
    <textarea id="description" class="form-control" name="description">{{ old('description', $post->description ?? null) }}</textarea>
    @error('description')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-2">
    <label for="published_at">Published At</label>
    <input id="published_at" class="form-control" type="datetime-local" name="published_at"
        value="{{ old('published_at', $post->published_at ?? null) }}">
</div>

<div class="form-group mt-2">
    <label for="category">Category</label>
    <select id="category" class="form-control" name="category">
        <option value="">Select a category</option>
        @foreach ($categories as $key => $category)
            <option value="{{ $key }}" @selected(old('category', $post->category ?? null) == $key)>
                {{ $category }}</option>
        @endforeach
    </select>
    @error('category')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

<div class="form-group mt-2">
    <label for="is_featured">Is Featured</label>
    <div class="form-check mt-2">
        <input id="is_featured_yes" class="form-check-input" type="radio" name="is_featured" value="1"
            @checked(old('is_featured', $post->is_featured ?? null) == 1)>
        <label for="is_featured_yes">Yes</label>
    </div>
    <div class="form-check mt-2">
        <input id="is_featured_no" class="form-check-input" type="radio" name="is_featured" value="0"
            @checked(old('is_featured', $post->is_featured ?? null) == 0)>
        <label for="is_featured_no">No</label>
    </div>
</div>

<div class="form-group mt-2">
    <label for="tags">Tags</label>
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
    <label for="image">Image</label>
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
    <label for="body">Body</label>
    <input id="body" type="hidden" name="body" value="{{ old('body', $post->body ?? null) }}">
    <trix-editor input="body"></trix-editor>
    @error('body')
        <div class="text-danger strong">{{ $message }}</div>
    @enderror
</div>

@push('styles')
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
    <script src="{{ asset('theme/jquery.min.js') }}"></script>

    <script type="text/javascript" src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <Script>
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
    </Script>
@endpush
