<x-layout :title="__('posts.form.Edit Post')">
    <div class="mx-auto max-w-5xl space-y-8">
        <div class="border-b border-stone-200 pb-6">
            <div class="flex flex-wrap items-center gap-3 text-sm font-medium text-stone-500">
                <a href="{{ route('posts.show', $post) }}" class="transition hover:text-stone-950">Back to post</a>
                <span>/</span>
                <a href="{{ route('posts.index') }}" class="transition hover:text-stone-950">All posts</a>
            </div>

            <div class="mt-4 space-y-3">
                <p class="text-xs font-medium uppercase tracking-[0.24em] text-red-600">Revision</p>
                <h1 class="font-serif text-4xl tracking-tight text-stone-950 sm:text-5xl">{{ __('posts.form.Edit Post') }}</h1>
                <p class="max-w-2xl text-base leading-7 text-stone-600">Refine the structure, tighten the metadata, and adjust the final presentation before publishing.</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-sm">
            <form action="{{ route('posts.update', [$post]) }}" method="POST" enctype="multipart/form-data" class="space-y-8 p-6 sm:p-8">
                @csrf
                @method('PUT')
                @include('posts._form', ['post' => $post, 'categories' => $categories, 'tags' => $tags])

                <div class="flex flex-wrap items-center gap-3 border-t border-stone-200 pt-6">
                    <x-button color="blue">{{ __('posts.form.Update Post') }}</x-button>
                    <x-button href="{{ route('posts.show', $post) }}" color="zinc">View post</x-button>
                    <x-button href="{{ route('posts.index') }}" color="zinc">{{ __('posts.form.Cancel') }}</x-button>
                </div>
            </form>
        </div>
    </div>
</x-layout>
