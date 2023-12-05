@extends('layouts.app')
@section('title', 'Create Post')
@section('content')

    <div class="row">
        <div class="col-12">
            <h1>Create Post</h1>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('posts._form', ['categories' => $categories, 'tags' => $tags])
                <div class="form-group">
                    <button type="submit" class="btn btn-success">Create Post</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
