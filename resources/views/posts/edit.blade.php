@extends('layouts.app')
@section('title', 'Edit Post')
@section('content')

    <div class="row">
        <div class="col-12">
            <h1>Edit Post</h1>
            <form action="{{ route('posts.update', [$post]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('posts._form', ['post' => $post, 'categories' => $categories, 'tags' => $tags])
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Edit Post</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
