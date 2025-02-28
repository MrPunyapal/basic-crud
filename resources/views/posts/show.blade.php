@use('App\Enums\FeaturedStatus')
@extends('layouts.app')
@section('title', $post->title)
@section('content')
    <div class="max-w-xl w-full mx-auto flex flex-col p-0 m-0">
        <x-button class="self-end" :href="route('posts.index')">
            {{ __('posts.show.View All') }}
        </x-button>
        <div class="bg-gray-50 mt-4 shadow-sm overflow-hidden rounded-lg">
            <img src="{{ $post->image }}" class="w-full" alt="{{ $post->title }}" height="400" />
            <div class="px-3 py-4 bg-white shadow-xs rounded-sm m-1">
                <div class="flex gap-x-4">
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold mb-2">
                            {{ $post->title }}
                        </h1>
                        <time class="text-sm text-zinc-500 mb-2" datetime="{{ $post->published_at }}">
                            {{ $post->category_title }} {{ optional($post->published_at)->format('M d, Y h:i a') }}
                        </time>
                    </div>
                    <div class="flex self-start gap-x-4">
                        <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <x-button :color="$post->is_featured->buttonColor()" type="submit">
                                {{ $post->is_featured->changeBtnLabel() }}
                            </x-button>
                        </form>
                        <x-button color="blue" :href="route('posts.edit', ['post' => $post])">
                            {{ __('posts.show.Edit') }}
                        </x-button>
                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline"
                              onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                            @csrf
                            @method('DELETE')
                            <x-button color="red" type="submit">
                                {{ __('posts.show.Delete') }}
                            </x-button>
                        </form>
                    </div>
                </div>
                <p class="text-gray-700 mt-4 trix-content">
                    {!! $post->content !!}
                </p>
            </div>
            <div class="bg-gray-50 px-3 py-4">
                <div class="flex justify-between">
                    <div>
                        @isset($post->tags)
                            @foreach ($post->tags as $tag)
                            <span
                                class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">{{ $tag }}</span>
                            @endforeach
                        @endisset                       
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
