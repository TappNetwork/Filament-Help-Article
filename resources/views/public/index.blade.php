<x-help-layout title="Help Articles">
    <div>
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Help Articles</h1>

        @if($articles->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-4">
                @foreach($articles as $article)
                    <a href="{{ route('filament-help.public.show', $article->slug) }}" class="group">
                        <div class="fi-card relative rounded-xl bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 transition-all duration-200 hover:shadow-md hover:ring-gray-950/10 dark:hover:ring-white/20 h-full flex flex-col">
                            <div class="p-6 flex-1">
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                                    {{ $article->name }}
                                </h2>
                                @if($article->updated_at)
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        Last updated {{ $article->updated_at->format('M j, Y') }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $articles->links('filament-help::components.pagination') }}
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No help articles available</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    There are no public help articles at this time.
                </p>
            </div>
        @endif

        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Homepage
                </a>
            @else
                <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Homepage
                </a>
            @endif
        </div>
    </div>
</x-help-layout>

