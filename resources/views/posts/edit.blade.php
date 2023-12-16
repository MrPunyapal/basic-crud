@extends('layouts.app')
@section('title', __('posts.form.Edit Post'))
@section('content')

    <div class="row">
        <div class="col-12">
            <h1>{{ __('posts.form.Edit Post') }}</h1>
            <form action="{{ route('posts.update', [$post]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('posts._form', ['post' => $post, 'categories' => $categories, 'tags' => $tags])
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-success">{{ __('posts.form.Update Post') }}</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                        {{ __('posts.form.Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
