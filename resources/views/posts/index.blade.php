@inject('queryResolver', 'App\Support\QueryResolver')
<x-layout :title="__('posts.index.Posts')">
    <div class="space-y-8">
        <section class="space-y-6 border-b border-stone-200 pb-6 lg:flex lg:items-end lg:justify-between lg:gap-8 lg:space-y-0">
            <div>
                <h1 class="font-serif text-4xl tracking-tight text-stone-950 sm:text-5xl">{{ __('posts.index.Posts') }}</h1>
            </div>

            <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center lg:w-auto lg:justify-end">
                <form action="{{ route('posts.index') }}" class="flex w-full flex-col gap-3 sm:w-auto sm:flex-row sm:items-center">
                    @foreach ($queryResolver->searchQuery() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label for="posts-search" class="sr-only">{{ __('posts.form.Search here') }}</label>
                    <x-text-field
                        id="posts-search"
                        type="search"
                        name="search"
                        :value="$queryResolver->searchValue()"
                        class="sm:w-80"
                        placeholder="{{ __('posts.form.Search here') }}"
                    />
                    <x-button color="zinc" type="submit">Search</x-button>
                </form>

                <x-button color="blue" :href="route('posts.index', $queryResolver->publishedQuery())">{{ $queryResolver->publishedLabel() }}</x-button>
            </div>
        </section>

        @session('success')
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ $value }}
            </div>
        @endsession

        <div class="overflow-hidden rounded-xl border border-stone-200 bg-white">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50/80 text-left text-xs font-semibold uppercase tracking-[0.18em] text-stone-500">
                        <tr>
                            <th class="w-16 px-4 py-4 sm:px-6">
                                #
                            </th>
                            <th class="w-[34%] min-w-[16rem] px-4 py-4 sm:px-6">
                                <a class="inline-flex items-center gap-1 whitespace-nowrap transition hover:text-stone-950"
                                   href="{{ route('posts.index', $queryResolver->sortQuery('title')) }}">
                                    <span>{{ __('posts.form.Title') }}</span>
                                    {!! $queryResolver->sortArrow('title') !!}
                                </a>
                            </th>
                            <th class="w-32 px-4 py-4 sm:px-6">
                                {{ __('posts.form.Category') }}
                            </th>
                            <th class="w-32 px-4 py-4 sm:px-6">
                                <a class="inline-flex items-center gap-1 whitespace-nowrap transition hover:text-stone-950"
                                   href="{{ route('posts.index', $queryResolver->sortQuery('is_featured')) }}">
                                    <span>Featured</span>
                                    {!! $queryResolver->sortArrow('is_featured') !!}
                                </a>
                            </th>
                            <th class="w-32 px-4 py-4 sm:px-6">
                                <a class="inline-flex items-center gap-1 whitespace-nowrap transition hover:text-stone-950"
                                   href="{{ route('posts.index', $queryResolver->sortQuery('created_at')) }}">
                                    <span>Created</span>
                                    {!! $queryResolver->sortArrow('created_at') !!}
                                </a>
                            </th>
                            <th class="w-32 px-4 py-4 whitespace-nowrap sm:px-6">
                                Updated
                            </th>
                            <th class="w-44 px-4 py-4 whitespace-nowrap sm:px-6">
                                {{ __('posts.form.Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200 bg-white">
                        @forelse ($posts as $post)
                            <tr class="align-top transition hover:bg-stone-50/80">
                                <td class="whitespace-nowrap px-4 py-4 font-medium text-stone-500 sm:px-6">
                                    <div class="grid size-8 place-items-center rounded-full border border-stone-200 bg-stone-50 text-xs font-semibold text-stone-700">
                                        {{ $loop->index + $posts->firstItem() }}
                                    </div>
                                </td>
                                <td class="min-w-[16rem] px-4 py-4 text-stone-900 sm:px-6">
                                    <div class="space-y-1">
                                        <a href="{{ route('posts.show', ['post' => $post]) }}"
                                           class="line-clamp-2 text-base font-semibold leading-7 text-stone-950 transition hover:text-red-600">
                                            {{ $post->title }}
                                        </a>
                                        @if ($post->description)
                                            <p class="hidden truncate text-sm leading-6 text-stone-500 2xl:block">{{ $post->description }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-stone-700 sm:px-6">
                                    <span class="inline-flex rounded-full border border-stone-200 bg-stone-50 px-3 py-1 text-xs font-medium text-stone-600">
                                        {{ $post->category_title }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 sm:px-6">
                                    @if ($post->is_featured->value)
                                        <span class="inline-flex rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-medium text-red-700">
                                            Featured
                                        </span>
                                    @else
                                        <span class="inline-flex rounded-full border border-stone-200 bg-white px-3 py-1 text-xs font-medium text-stone-600">
                                            Regular
                                        </span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-stone-500 sm:px-6">
                                    {{ $post->created_at->format('M d, Y') }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 text-stone-500 sm:px-6">
                                    {{ $post->updated_at->since() }}
                                </td>
                                <td class="whitespace-nowrap px-4 py-4 sm:px-6">
                                    <div class="flex items-center gap-3 whitespace-nowrap text-xs font-medium sm:text-sm">
                                        <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="transition hover:underline {{ $post->is_featured->value ? 'text-amber-700' : 'text-stone-700 hover:text-stone-950' }}" title="{{ $post->is_featured->changeBtnLabel() }}">
                                                {{ $post->is_featured->changeBtnLabel() }}
                                            </button>
                                        </form>

                                        <a href="{{ route('posts.edit', ['post' => $post]) }}"
                                           class="text-stone-700 transition hover:text-stone-950 hover:underline"
                                           title="{{ __('posts.show.Edit') }}">
                                            {{ __('posts.show.Edit') }}
                                        </a>

                                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline"
                                              onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-700 transition hover:underline" title="{{ __('posts.show.Delete') }}">
                                                {{ __('posts.show.Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-16 text-center sm:px-6">
                                    <div class="mx-auto max-w-md space-y-4">
                                        <h3 class="font-serif text-3xl tracking-tight text-stone-950">No posts found</h3>
                                        <p class="text-base leading-7 text-stone-600">Start the archive with a first post, then return here to sort, review, and refine it.</p>
                                        <a href="{{ route('posts.create') }}"
                                           class="inline-flex items-center justify-center rounded-full border border-stone-950 bg-stone-950 px-4 py-2 text-sm font-medium text-white transition hover:border-stone-800 hover:bg-stone-800">
                                            {{ __('posts.form.Create Post') }}
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($posts->hasPages())
            <div class="rounded-xl border border-stone-200 bg-white p-4 sm:p-6">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</x-layout>
