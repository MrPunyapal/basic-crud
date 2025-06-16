@inject('queryResolver', 'App\Support\QueryResolver')
@use('App\Support\Settings')
<x-layout :title="__('posts.index.Posts')">
    <div class="space-y-8">
        <!-- Header Section -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-700 to-purple-700 bg-clip-text text-transparent">
                    {{ __('posts.index.Posts') }}
                </h1>
                <p class="text-slate-600 mt-2">Manage your blog posts and content</p>
            </div>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 w-full lg:w-auto">
                <!-- Header Search -->
                <form action="{{ route('posts.index') }}" class="w-full sm:w-auto">
                    @foreach ($queryResolver->searchQuery() as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <div class="relative">
                        <input type="search"
                               name="search"
                               placeholder="{{ __('posts.form.Search here') }}"
                               value="{{ $queryResolver->searchValue() }}"
                               class="w-full sm:w-80 pl-10 pr-12 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200 bg-white/70 backdrop-blur-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <button type="submit" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-blue-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5-5 5M6 12h12"></path>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Published Posts Button -->
                <x-button color="blue" :href="route('posts.index', $queryResolver->publishedQuery())" class="flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl transition-all duration-200 font-medium hover:scale-105 shadow-lg hover:shadow-xl whitespace-nowrap">
                    <i class="fas fa-eye"></i>
                    <span>{{ $queryResolver->publishedLabel() }}</span>
                </x-button>
            </div>
        </div>

        @session('success')
            <div class="glass border border-green-200 bg-green-50/50 text-green-800 p-4 rounded-xl animate-slide-up">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <i class="fas fa-check-circle text-green-600"></i>
                        <span>{{ $value }}</span>
                    </div>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-600 hover:text-green-800 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endsession

        <!-- Posts Table -->
        <div class="glass rounded-2xl overflow-hidden border border-white/20">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-slate-50 to-blue-50 border-b border-white/20">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                #
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <a class="flex items-center space-x-1 hover:text-blue-600 transition-colors duration-200"
                                   href="{{ route('posts.index', $queryResolver->sortQuery('title')) }}">
                                    <span>{{ __('posts.form.Title') }}</span>
                                    {!! $queryResolver->sortArrow('title') !!}
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                {{ __('posts.form.Category') }}
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <a class="flex items-center space-x-1 hover:text-blue-600 transition-colors duration-200"
                                   href="{{ route('posts.index', $queryResolver->sortQuery('is_featured')) }}">
                                    <span>{{ __('posts.form.Is Featured') }}</span>
                                    {!! $queryResolver->sortArrow('is_featured') !!}
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                <a class="flex items-center space-x-1 hover:text-blue-600 transition-colors duration-200"
                                   href="{{ route('posts.index', $queryResolver->sortQuery('created_at')) }}">
                                    <span>{{ __('posts.form.Created At') }}</span>
                                    {!! $queryResolver->sortArrow('created_at') !!}
                                </a>
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                {{ __('posts.form.Updated At') }}
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                {{ __('posts.form.Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white/50 backdrop-blur-sm divide-y divide-slate-200">
                        @forelse ($posts as $post)
                            <tr class="hover:bg-blue-50/30 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center text-white text-xs font-bold">
                                        {{ $loop->index + $posts->firstItem() }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-900 max-w-xs">
                                    <div class="flex flex-col">
                                        <a href="{{ route('posts.show', ['post' => $post]) }}"
                                           class="font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200 line-clamp-2">
                                            {{ $post->title }}
                                        </a>
                                        @if($post->description)
                                            <p class="text-xs text-slate-500 mt-1 line-clamp-1">{{ $post->description }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    <div class="flex items-center">
                                        <span class="bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">
                                            {{ $post->category_title }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                    @if($post->is_featured->value)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gradient-to-r from-yellow-400 to-orange-400 text-white">
                                            <i class="fas fa-star mr-1"></i>
                                            Featured
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                            <i class="fas fa-file-alt mr-1"></i>
                                            Regular
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-calendar text-blue-500"></i>
                                        <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <div class="flex items-center space-x-1">
                                        <i class="fas fa-clock text-green-500"></i>
                                        <span>{{ $post->updated_at->since() }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        <!-- Featured Toggle -->
                                        <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-xs px-2 py-1 rounded-lg transition-all duration-200 hover:scale-105 {{ $post->is_featured->value ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}" title="{{ $post->is_featured->changeBtnLabel() }}">
                                                <i class="{{ $post->is_featured->value ? 'fas fa-star' : 'far fa-star' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Edit Button -->
                                        <a href="{{ route('posts.edit', ['post' => $post]) }}"
                                           class="text-xs px-2 py-1 bg-blue-100 text-blue-800 hover:bg-blue-200 rounded-lg transition-all duration-200 hover:scale-105"
                                           title="{{ __('posts.show.Edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete Button -->
                                        <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline"
                                              onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs px-2 py-1 bg-red-100 text-red-800 hover:bg-red-200 rounded-lg transition-all duration-200 hover:scale-105" title="{{ __('posts.show.Delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-gradient-to-r from-slate-200 to-slate-300 rounded-full flex items-center justify-center mb-4">
                                            <i class="fas fa-file-alt text-2xl text-slate-500"></i>
                                        </div>
                                        <h3 class="text-lg font-semibold text-slate-700 mb-2">No posts found</h3>
                                        <p class="text-slate-500 mb-4">Create your first post to get started</p>
                                        <a href="{{ route('posts.create') }}"
                                           class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-4 py-2 rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-200 font-medium hover:scale-105 shadow-lg hover:shadow-xl">
                                            <i class="fas fa-plus"></i>
                                            <span>{{ __('posts.form.Create Post') }}</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if ($posts->hasPages())
            <div class="glass rounded-2xl p-6 border border-white/20">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</x-layout>
