@extends('layouts.app')
@section('title', __('posts.create.Create Post'))
@section('content')

    <div class="row">
        <div class="col-12">
            <h1>{{ __('posts.create.Create Post') }}</h1>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('posts._form', ['categories' => $categories, 'tags' => $tags])
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-success">{{ __('posts.form.Save Post') }}</button>
                    <a href="{{ route('posts.index') }}" class="btn btn-secondary">
                        {{ __('posts.form.Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
