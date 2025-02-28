@inject('queryResolver', 'App\Support\QueryResolver')
@use('App\Support\Settings')
@extends('layouts.app')
@section('title', __('posts.index.Posts'))
@section('content')
    <div class="flex flex-col">
        <h1 class="text-2xl font-bold">{{ __('posts.index.Posts') }}</h1>

        @session('success')
            <div class="bg-green-200 text-green-800 p-4 my-4">
                {{ $value }}
                <span class="float-right cursor-pointer text-xl" onclick="this.parentElement.remove()">x</span>
            </div>
        @endsession

        <div class="flex justify-between items-center">
            <div>
                <div class="flex gap-x-4">
                    <x-button color="green" :href="route('posts.create')">
                        {{ __('posts.form.Create Post') }}
                    </x-button>
                    <x-button color="blue" :href="route('posts.index', $queryResolver->publishedQuery())">
                        {{ $queryResolver->publishedLabel() }}
                    </x-button>
                    <div class="relative inline-block text-left ms-2">
                        <x-button onclick="this.nextElementSibling.classList.toggle('hidden')">
                            <span>{{ __('posts.index.Languages') }} &#x25BE;</span>
                        </x-button>
                        <div class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg hidden bg-white ring-1 ring-black ring-opacity-5 focus:outline-hidden"
                            role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                            @foreach (Settings::getLocales() as $locale => $Label)
                                <a @class([
                                    'block px-4 py-2 text-sm',
                                    'text-gray-700 hover:bg-gray-100 hover:text-gray-900' =>
                                        $locale != app()->getLocale(),
                                    'text-white bg-blue-500' => $locale == app()->getLocale(),
                                ])
                                    {{ $locale != app()->getLocale() ? 'href=' . route('set-locale', ['locale' => $locale]) : '' }}>{{ $Label }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <form class="mb-4" action="{{ route('posts.index') }}">
                @foreach ($queryResolver->searchQuery() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="flex items-center [&>button]:rounded-s-none [&>input]:rounded-e-none [&>input]:border-e-0">
                    <x-text-field name="search" placeholder="{{ __('posts.form.Search here') }}" type="search"
                        value="{{ $queryResolver->searchValue() }}" />
                    <x-button type="submit">
                        {{ __('posts.form.Search') }}
                    </x-button>
                </div>
            </form>
        </div>
        <div class="w-full overflow-x-auto">
            <table class="table-auto border border-slate-500 min-w-full">
                <thead>
                    <tr>
                        <th class="border border-slate-600">#</th>
                        <th class="border border-slate-600">
                            <a class="text-decoration-none text-dark"
                                href="{{ route('posts.index', $queryResolver->sortQuery('title')) }}">
                                {{ __('posts.form.Title') }}
                                {!! $queryResolver->sortArrow('title') !!}
                            </a>
                        </th>
                        <th class="border border-slate-600"> {{ __('posts.form.Category') }} </th>
                        <th class="border border-slate-600">
                            <a class="text-decoration-none text-dark"
                                href="{{ route('posts.index', $queryResolver->sortQuery('is_featured')) }}">
                                {{ __('posts.form.Is Featured') }}
                                {!! $queryResolver->sortArrow('is_featured') !!}
                            </a>
                        </th>
                        <th class="border border-slate-600">{{ __('posts.form.Created At') }}</th>
                        <th class="border border-slate-600">{{ __('posts.form.Updated At') }}
                        <th class="border border-slate-600">{{ __('posts.form.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td class="border border-slate-600 py-2 px-4">
                                {{ $loop->index + $posts->firstItem() }}
                            </td>
                            <td class="border border-slate-600 py-2 px-4">
                                <a href="{{ route('posts.show', ['post' => $post]) }}"
                                    class="underline">{{ $post->title }}</a>
                            </td>
                            <td class="border border-slate-600 py-2 px-4">{{ $post->category_title }}</td>
                            <td class="border border-slate-600 py-2 px-4">{{ $post->is_featured->BooleanLabel() }}</td>
                            <td class="border border-slate-600 py-2 px-4">{{ $post->created_at->format('d/m/Y H:i:s') }}
                            </td>
                            <td class="border border-slate-600 py-2 px-4">{{ $post->updated_at->since() }}</td>
                            <td class="border border-slate-600 py-2 px-4 text-nowrap">
                                <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <x-button :color="$post->is_featured->buttonColor()" type="submit" class="w-24">
                                        {{ $post->is_featured->changeBtnLabel() }}
                                    </x-button>
                                </form>
                                <x-button color="blue" href="{{ route('posts.edit', ['post' => $post]) }}">
                                    {{ __('posts.show.Edit') }}
                                </x-button>
                                <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <x-button color="red" type="submit">
                                        {{ __('posts.show.Delete') }}
                                    </x-button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($posts->hasPages())
                    <tfoot>
                        <tr>
                            <td colspan="7">
                                <div class="p-2">
                                    {{ $posts->links() }}
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>
@endsection
