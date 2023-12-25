@use('App\Enums\FeaturedStatus')
@extends('layouts.app')
@section('title', $post->title)
@section('content')
    <div class="flex flex-col p-0 m-0">
        <div class="flex justify-end mt-2">
            <a href="{{ route('posts.index') }}" class="btn btn-secondary">{{ __('posts.show.View All') }}</a>
        </div>
        <div class="bg-white shadow-lg rounded-lg overflow-hidden mx-auto">
            <img src="{{ $post->image }}" class="w-full" alt="{{ $post->title }}" height="400">
            <div class="p-6">
                <h5 class="text-xl font-bold mb-2">
                    {{ $post->title }}
                    <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <input type="submit" value="{{ $post->is_featured->changeBtnLabel() }}"
                            class="{{ $post->is_featured->changeBtnColor() }} text-white font-bold py-2 px-4 rounded">
                    </form>
                    <a href="{{ route('posts.edit', ['post' => $post]) }}"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">{{ __('posts.show.Edit') }}</a>
                    <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline"
                        onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="{{ __('posts.show.Delete') }}"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    </form>
                </h5>
                <h6 class="text-sm text-gray-500 mb-2">
                    {{ $post->category_title }} {{ optional($post->published_at)->format('M d, Y h:i a') }}
                </h6>
                <p class="text-gray-700 trix-content">
                    {!! $post->content !!}
                </p>
            </div>
            <div class="bg-gray-100 p-6">
                <div class="flex justify-between">
                    <div>
                        @foreach ($post->tags as $tag)
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div>
                        <span
                            class="inline-block {{ $post->is_featured->color() }} text-white px-3 py-1 text-sm font-semibold rounded-full">{{ $post->is_featured->label() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
