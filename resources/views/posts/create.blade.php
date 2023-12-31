@extends('layouts.app')
@section('title', __('posts.form.Create Post'))
@section('content')

    <div class="flex justify-center">
        <div class="lg:w-2/3 bg-white p-6 rounded-lg">
            <h1 class="text-2xl font-bold">{{ __('posts.form.Create Post') }}</h1>
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @include('posts._form', ['categories' => $categories, 'tags' => $tags])

                <div class="flex items-center gap-x-4 mt-8">
                    <x-button color="green">
                        {{ __('posts.form.Save Post') }}
                    </x-button>
                    <x-button href="{{ route('posts.index') }}">
                        {{ __('posts.form.Cancel') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
@endsection
