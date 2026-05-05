<x-layout :title="$post->title">
    <div class="mx-auto max-w-5xl space-y-8">
        <div class="flex flex-col gap-6 border-b border-stone-200 pb-8 lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-4">
                <a href="{{ route('posts.index') }}" class="text-sm font-medium text-stone-500 transition hover:text-stone-950">{{ __('posts.show.View All') }}</a>

                <div class="flex flex-wrap items-center gap-3 text-sm text-stone-500">
                    <span class="rounded-full border border-stone-200 bg-stone-50 px-3 py-1 font-medium uppercase tracking-[0.16em] text-stone-600">{{ $post->category_title }}</span>
                    <span class="rounded-full border px-3 py-1 font-medium {{ $post->is_featured->value ? 'border-red-200 bg-red-50 text-red-700' : 'border-stone-200 bg-white text-stone-600' }}">{{ $post->is_featured->label() }}</span>
                    @if ($post->published_at)
                        <span>Published {{ $post->published_at->format('M d, Y h:i a') }}</span>
                    @endif
                    <span>Updated {{ $post->updated_at->since() }}</span>
                </div>

                <div class="space-y-3">
                    <h1 class="max-w-4xl font-serif text-4xl tracking-tight text-stone-950 sm:text-5xl lg:text-6xl">{{ $post->title }}</h1>

                    @if ($post->description)
                        <p class="max-w-3xl text-lg leading-8 text-stone-600">{{ $post->description }}</p>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center justify-center rounded-full border px-4 py-2 text-sm font-medium transition {{ $post->is_featured->value ? 'border-amber-200 bg-amber-50 text-amber-800 hover:border-amber-300 hover:bg-amber-100' : 'border-stone-300 bg-white text-stone-700 hover:border-stone-400 hover:text-stone-950' }}">
                        {{ $post->is_featured->changeBtnLabel() }}
                    </button>
                </form>

                <x-button color="blue" :href="route('posts.edit', ['post' => $post])">{{ __('posts.show.Edit') }}</x-button>

                <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline"
                      onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                    @csrf
                    @method('DELETE')
                    <x-button color="red" type="submit">{{ __('posts.show.Delete') }}</x-button>
                </form>
            </div>
        </div>

        <article class="overflow-hidden rounded-[2rem] border border-stone-200 bg-white shadow-sm">
            @if ($post->image)
                <div class="overflow-hidden border-b border-stone-200 bg-stone-100" data-post-image>
                    <img src="{{ $post->image }}"
                         class="h-80 w-full object-cover sm:h-[28rem]"
                         onerror="this.closest('[data-post-image]').remove()"
                         alt="{{ $post->title }}" />
                </div>
            @endif

            <div class="px-6 py-8 sm:px-10 sm:py-10">
                <div class="article-content max-w-none">
                    {!! $post->content !!}
                </div>
            </div>

            <footer class="border-t border-stone-200 bg-stone-50 px-6 py-5 sm:px-10">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap gap-2">
                        @isset($post->tags)
                            @foreach ($post->tags as $tag)
                                <span class="inline-flex rounded-full border border-stone-200 bg-white px-3 py-1 text-sm font-medium text-stone-600">
                                    {{ $tag }}
                                </span>
                            @endforeach
                        @endisset
                    </div>

                    <div>
                        <span class="inline-flex rounded-full border px-3 py-1 text-sm font-medium {{ $post->is_featured->value ? 'border-red-200 bg-red-50 text-red-700' : 'border-stone-200 bg-white text-stone-600' }}">
                            {{ $post->is_featured->label() }}
                        </span>
                    </div>
                </div>
            </footer>
        </article>
    </div>
</x-layout>
