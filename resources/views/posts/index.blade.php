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
                <a href="{{ route('posts.create') }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">{{ __('posts.form.Create Post') }}</a>
                <a href="{{ route('posts.index', $queryResolver->publishedQuery()) }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    {{ $queryResolver->publishedLabel() }}
                </a>

                <div class="relative inline-block text-left ms-2">
                    <button type="button" onclick="this.nextElementSibling.classList.toggle('hidden')"
                        class="bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded inline-flex items-center">
                        <span>{{ __('posts.index.Languages') }} &#x25BE;</span>
                    </button>
                    <div class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg hidden bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                        role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        @foreach (Settings::getLocales() as $locale => $Label)
                            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                                href="{{ route('set-locale', ['locale' => $locale]) }}">{{ $Label }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <form class="mb-4" action="{{ route('posts.index') }}">
                @foreach ($queryResolver->searchQuery() as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                <div class="flex items-center">
                    <input type="search" name="search" class="border border-gray-300 rounded-l-md py-2 px-4"
                        placeholder="{{ __('posts.form.Search here') }}" value="{{ $queryResolver->searchValue() }}">
                    <button type="submit"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-r-md">
                        {{ __('posts.form.Search') }}
                    </button>
                </div>
            </form>
        </div>
        <table class="table-auto border border-slate-500">
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
                            <a href="{{ route('posts.show', ['post' => $post]) }}">{{ $post->title }}</a>
                        </td>
                        <td class="border border-slate-600 py-2 px-4">{{ $post->category_title }}</td>
                        <td class="border border-slate-600 py-2 px-4">{{ $post->is_featured->BooleanLabel() }}</td>
                        <td class="border border-slate-600 py-2 px-4">{{ $post->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="border border-slate-600 py-2 px-4">{{ $post->updated_at->since() }}</td>
                        <td class="border border-slate-600 py-2 px-4">
                            <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="submit" value="{{ $post->is_featured->changeBtnLabel() }}"
                                    class="{{ $post->is_featured->changeBtnColor() }} text-white font-bold py-1 px-2 rounded w-24">
                            </form>
                            <a href="{{ route('posts.edit', ['post' => $post]) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-2 rounded">{{ __('posts.show.Edit') }}</a>
                            <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline"
                                onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="{{ __('posts.show.Delete') }}"
                                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-2 rounded">
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">No posts found.</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="p-2">
                            {{ $posts->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
@endsection
