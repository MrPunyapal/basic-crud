@use('App\Enums\FeaturedStatus')
@extends('layouts.app')
@section('title', __('posts.index.Posts'))
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>{{ __('posts.index.Posts') }}</h1>

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('posts.create') }}" class="btn btn-success">{{ __('posts.create.Create Post') }}</a>
                    @if (request('published') == false)
                        <a href="{{ route('posts.index', ['published' => true]) }}" class="btn btn-primary">
                            {{ __('posts.index.Published Posts') }}
                        </a>
                    @else
                        <a href="{{ route('posts.index') }}" class="btn btn-primary">
                            {{ __('posts.index.All Posts') }}
                        </a>
                    @endif
                </div>
                <form method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control"
                            placeholder="{{ __('posts.form.Search here') }}
                            value="{{ request()->search }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary">
                                {{ __('posts.form.Search') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <a
                                href="?sortBy=title&direction={{ request('direction') === 'asc' ? 'desc' : 'asc' }}">{{ __('posts.form.Title') }}</a>
                        </th>
                        <th> {{ __('posts.form.Category') }} </th>
                        <th>{{ __('posts.form.Is Featured') }} </th>
                        <th>{{ __('posts.form.Created At') }}</th>
                        <th>{{ __('posts.form.Updated At') }}
                        <th>{{ __('posts.form.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>
                                {{ $loop->index + $posts->firstItem() }}
                            </td>
                            <td>
                                <a href="{{ route('posts.show', ['post' => $post]) }}">{{ $post->title }}</a>
                            </td>
                            <td>{{ $post->category_title }}</td>
                            <td>{{ $post->is_featured->label() }}</td>
                            <td>{{ $post->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $post->updated_at->since() }}</td>
                            <td>
                                <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="submit" value="{{ $post->is_featured->changeBtnLabel() }}"
                                        @class(['btn', $post->is_featured->changeBtnColor()])>
                                </form>
                                <a href="{{ route('posts.edit', ['post' => $post]) }}"
                                    class="btn btn-primary">{{ __('posts.show.Edit') }}</a>
                                <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="{{ __('posts.show.Delete') }}" class="btn btn-danger">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>
@endsection
