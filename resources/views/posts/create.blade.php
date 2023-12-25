@extends('layouts.app')
@section('title', __('posts.form.Create Post'))
@section('content')

    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-bold">{{ __('posts.form.Create Post') }}</h1>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('posts._form', ['categories' => $categories, 'tags' => $tags])
                <div class="mt-4">
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded">{{ __('posts.form.Save Post') }}</button>
                    <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded ml-2">
                        {{ __('posts.form.Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
