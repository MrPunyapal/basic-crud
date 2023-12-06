@extends('layouts.app')
@section('title', $post->title)
@section('content')
    <div class="row">
        <div class="card">
            <img src="{{ $post->image }}" class="card-img-top" alt="{{ $post->title }}">
            <div class="card-body">
                <h5 class="card-title">
                    {{ $post->title }}
                    <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete" class="btn btn-danger">
                    </form>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted ">
                    {{ $categories[$post->category] }}
                </h6>
                <p class="card-text">
                    {!! $post->body !!}
                </p>
            </div>
        </div>
    </div>
@endsection
