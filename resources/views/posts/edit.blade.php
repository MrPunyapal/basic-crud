<x-layout :title="__('posts.form.Edit Post')">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <a href="{{ route('posts.show', $post) }}" class="flex items-center space-x-2 text-slate-600 hover:text-blue-600 transition-colors duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Post</span>
                </a>
                <span class="text-slate-400">•</span>
                <a href="{{ route('posts.index') }}" class="flex items-center space-x-2 text-slate-600 hover:text-blue-600 transition-colors duration-200">
                    <i class="fas fa-list"></i>
                    <span>All Posts</span>
                </a>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                {{ __('posts.form.Edit Post') }}
            </h1>
            <p class="text-slate-600 mt-2">Update your blog post content and settings</p>
        </div>

        <!-- Form Card -->
        <div class="glass rounded-2xl p-8 border border-white/20 animate-fade-in">
            <form action="{{ route('posts.update', [$post]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')
                @include('posts._form', ['post' => $post, 'categories' => $categories, 'tags' => $tags])

                <div class="flex items-center gap-4 pt-6 border-t border-white/20">
                    <x-button color="blue" class="flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>{{ __('posts.form.Update Post') }}</span>
                    </x-button>
                    <x-button href="{{ route('posts.show', $post) }}" color="zinc" class="flex items-center space-x-2">
                        <i class="fas fa-eye"></i>
                        <span>View Post</span>
                    </x-button>
                    <x-button href="{{ route('posts.index') }}" color="zinc" class="flex items-center space-x-2">
                        <i class="fas fa-times"></i>
                        <span>{{ __('posts.form.Cancel') }}</span>
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
