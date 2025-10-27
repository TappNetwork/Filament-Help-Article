<x-filament-panels::page>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="space-y-6">
            @if($this->helpArticles->count() > 0)
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                    @foreach($this->helpArticles as $article)
                        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                                {{ $article->name }}
                            </h3>
                            @if($article->content)
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
                                    {!! Str::limit(strip_tags($article->content), 150) !!}
                                </p>
                            @endif
                        <a href="/help/{{ $article->id }}" 
                           class="inline-flex items-center text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                            Read more
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No help articles available</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Check back later for helpful articles and guides.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
