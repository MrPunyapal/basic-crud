@extends('layouts.app')
@section('title', __('posts.form.Edit Post'))
@section('content')

    <div class="flex justify-center">
        <div class="lg:w-2/3 bg-white p-6 rounded-lg">
            <h1 class="text-2xl font-bold">{{ __('posts.form.Edit Post') }}</h1>
            <form action="{{ route('posts.update', [$post]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('posts._form', ['post' => $post, 'categories' => $categories, 'tags' => $tags])
                <div class="mt-4">
                    <button type="submit"
                        class="px-4 py-2 bg-green-500 text-white rounded">{{ __('posts.form.Update Post') }}</button>
                    <a href="{{ route('posts.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded ml-2">
                        {{ __('posts.form.Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
