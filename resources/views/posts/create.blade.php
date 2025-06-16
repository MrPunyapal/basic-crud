<x-layout :title="__('posts.form.Create Post')">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center space-x-3 mb-4">
                <a href="{{ route('posts.index') }}" class="flex items-center space-x-2 text-slate-600 hover:text-blue-600 transition-colors duration-200">
                    <i class="fas fa-arrow-left"></i>
                    <span>Back to Posts</span>
                </a>
            </div>
            <h1 class="text-4xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                {{ __('posts.form.Create Post') }}
            </h1>
            <p class="text-slate-600 mt-2">Create a new blog post and share your thoughts</p>
        </div>

        <!-- Form Card -->
        <div class="glass rounded-2xl p-8 border border-white/20 animate-fade-in">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @include('posts._form', ['categories' => $categories, 'tags' => $tags])

                <div class="flex items-center gap-4 pt-6 border-t border-white/20">
                    <x-button color="green" class="flex items-center space-x-2">
                        <i class="fas fa-save"></i>
                        <span>{{ __('posts.form.Save Post') }}</span>
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
