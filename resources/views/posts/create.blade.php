<x-layout :title="__('posts.form.Create Post')">
    <div class="mx-auto max-w-5xl space-y-8">
        <div class="border-b border-stone-200 pb-6">
            <a href="{{ route('posts.index') }}" class="text-sm font-medium text-stone-500 transition hover:text-stone-950">Back to posts</a>

            <div class="mt-4 space-y-3">
                <p class="text-xs font-medium uppercase tracking-[0.24em] text-red-600">Publishing</p>
                <h1 class="font-serif text-4xl tracking-tight text-stone-950 sm:text-5xl">{{ __('posts.form.Create Post') }}</h1>
                <p class="max-w-2xl text-base leading-7 text-stone-600">Create a new entry with a clear structure, concise metadata, and a headline that feels deliberate.</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-sm">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8 p-6 sm:p-8">
                @csrf
                @include('posts._form', ['categories' => $categories, 'tags' => $tags])

                <div class="flex flex-wrap items-center gap-3 border-t border-stone-200 pt-6">
                    <x-button color="green">{{ __('posts.form.Save Post') }}</x-button>
                    <x-button href="{{ route('posts.index') }}" color="zinc">{{ __('posts.form.Cancel') }}</x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
