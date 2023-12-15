@use('App\Enums\FeaturedStatus')
@extends('layouts.app')
@section('title', $post->title)
@section('content')
    <div class="row g-0 vh-100 p-0 m-0">
        <div class="col-12 text-end mt-2">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">View All</a>
        </div>
        <div class="card col-8 m-auto">
            <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->title }}" height="400">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $post->title }}
                    <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <input type="submit" value="{{ $post->is_featured ? 'unfeature' : 'feature' }}"
                            @class([
                                'btn',
                                'btn-secondary' => $post->is_featured,
                                'btn-success' => !$post->is_featured,
                            ])>
                    </form>
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted ">
                    {{ $post->category_title }} {{ $post->published_at?->format('M d, Y h:i a') }}
                </h6>
                <p class="card-text trix-content">
                    {!! $post->body !!}
                </p>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <div>
                        @foreach ($post->tags as $tag)
                            <span class="badge bg-secondary">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div>
                        @if ($post->is_featured === FeaturedStatus::FEATURED)
                            <span class="badge bg-success">Featured</span>
                        @else
                            <span class="badge bg-info">Not Featured</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
