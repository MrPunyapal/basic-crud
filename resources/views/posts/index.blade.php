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

            <p>
                <a href="{{ route('posts.create') }}" class="btn btn-success">Create Post</a>
            </p>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
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
                            <td>{{ $post->created_at->format('d/m/Y H:i:s') }}</td>
                            <td>{{ $post->updated_at->format('d/m/Y H:i:s') }}</td>
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
                            <td colspan="4">No posts found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>
@endsection
