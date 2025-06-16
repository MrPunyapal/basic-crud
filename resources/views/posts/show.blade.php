@use('App\Enums\FeaturedStatus')
<x-layout :title="$post->title">
    <div class="max-w-4xl mx-auto animate-fade-in">
        <!-- Header Navigation -->
        <div class="flex items-center justify-between mb-8">
            <a href="{{ route('posts.index') }}" class="flex items-center space-x-2 text-slate-600 hover:text-blue-600 transition-colors duration-200 group">
                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                <span>{{ __('posts.show.View All') }}</span>
            </a>

            <!-- Action Buttons -->
            <div class="flex items-center space-x-3">
                <form action="{{ route('posts.featured', ['post' => $post]) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="flex items-center space-x-2 px-4 py-2 rounded-xl transition-all duration-200 hover:scale-105 {{ $post->is_featured->value ? 'bg-yellow-100 text-yellow-800 hover:bg-yellow-200' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <i class="fas {{ $post->is_featured->value ? 'fa-star' : 'fa-star-o' }}"></i>
                        <span>{{ $post->is_featured->changeBtnLabel() }}</span>
                    </button>
                </form>
                <x-button color="blue" :href="route('posts.edit', ['post' => $post])" class="flex items-center space-x-2">
                    <i class="fas fa-edit"></i>
                    <span>{{ __('posts.show.Edit') }}</span>
                </x-button>
                <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST" class="inline"
                      onsubmit="return confirm('{{ __('posts.form.Are you sure you want to delete this post?') }}')">
                    @csrf
                    @method('DELETE')
                    <x-button color="red" type="submit" class="flex items-center space-x-2">
                        <i class="fas fa-trash"></i>
                        <span>{{ __('posts.show.Delete') }}</span>
                    </x-button>
                </form>
            </div>
        </div>

        <!-- Main Content Card -->
        <article class="glass rounded-2xl overflow-hidden border border-white/20 shadow-xl">
            <!-- Featured Image -->
            @if($post->image)
                <div class="relative h-96 overflow-hidden">
                    <img src="{{ $post->image }}"
                         class="w-full h-full object-cover"
                         alt="{{ $post->title }}" />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>
                    @if($post->is_featured->value)
                        <div class="absolute top-6 right-6 bg-gradient-to-r from-yellow-400 to-orange-400 text-white px-4 py-2 rounded-full text-sm font-medium flex items-center space-x-2 shadow-lg">
                            <i class="fas fa-star"></i>
                            <span>Featured</span>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Content -->
            <div class="p-8">
                <!-- Post Header -->
                <header class="mb-8">
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="bg-gradient-to-r from-blue-100 to-purple-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $post->category_title }}
                        </div>
                        <time class="text-slate-500 text-sm flex items-center space-x-1" datetime="{{ $post->published_at }}">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ optional($post->published_at)->format('M d, Y h:i a') }}</span>
                        </time>
                    </div>

                    <h1 class="text-4xl font-bold text-slate-800 leading-tight">
                        {{ $post->title }}
                    </h1>

                    @if($post->description)
                        <p class="text-xl text-slate-600 mt-4 leading-relaxed">
                            {{ $post->description }}
                        </p>
                    @endif
                </header>

                <!-- Post Content -->
                <div class="prose prose-lg max-w-none prose-headings:text-slate-800 prose-p:text-slate-700 prose-p:leading-relaxed prose-a:text-blue-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-xl prose-img:shadow-md">
                    {!! $post->content !!}
                </div>
            </div>

            <!-- Footer -->
            <footer class="bg-gradient-to-r from-slate-50 to-blue-50 px-8 py-6 border-t border-white/20">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2">
                        @isset($post->tags)
                            @foreach ($post->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/70 text-slate-700 border border-slate-200 hover:bg-white/90 transition-colors duration-200">
                                    <i class="fas fa-tag mr-1 text-xs"></i>
                                    {{ $tag }}
                                </span>
                            @endforeach
                        @endisset
                    </div>

                    <!-- Status Badge -->
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $post->is_featured->value ? 'bg-gradient-to-r from-yellow-400 to-orange-400 text-white' : 'bg-slate-200 text-slate-700' }}">
                            <i class="fas {{ $post->is_featured->value ? 'fa-star' : 'fa-file-alt' }} mr-1"></i>
                            {{ $post->is_featured->label() }}
                        </span>
                    </div>
                </div>
            </footer>
        </article>
    </div>
</x-layout>
