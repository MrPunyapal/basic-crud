@extends('layouts.app')
@section('title', 'Posts')
@section('content')
    <div class="row">
        <div class="col-12">
            <h1>Posts</h1>

            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif


            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('posts.create') }}" class="btn btn-success">Create Post</a>
                    @if (Route::is('posts.index'))
                        <a href="{{ route('posts.published') }}" class="btn btn-primary">Published Posts</a>
                    @else
                        <a href="{{ route('posts.index') }}" class="btn btn-primary">All Posts</a>
                    @endif
                </div>
                <form method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by title"
                            value="{{ request()->search }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-outline-secondary">Search</button>
                        </div>
                    </div>
                </form>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td>
                                <a href="{{ route('posts.show', ['post' => $post->id]) }}">{{ $post->title }}</a>
                            </td>
                            <td>{{ $categories[$post->category] }}</td>
                            <td>{{ $post->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $post->updated_at->since() }}</td>
                            <td>
                                <a href="{{ route('posts.edit', ['post' => $post->id]) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-danger">
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
