<x-layout :title="__('posts.form.Edit Post')">
    <div class="flex justify-center">
        <div class="lg:w-2/3 bg-white p-6 rounded-lg bg-white shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-2">{{ __('posts.form.Edit Post') }}</h1>
            <form action="{{ route('posts.update', [$post]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('posts._form', ['post' => $post, 'categories' => $categories, 'tags' => $tags])

                <div class="flex items-center gap-x-4 mt-8">
                    <x-button color="green">
                        {{ __('posts.form.Update Post') }}
                    </x-button>
                    <x-button href="{{ route('posts.index') }}">
                        {{ __('posts.form.Cancel') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
