<div class="max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $article->name }}</h1>
    @if($article->updated_at)
        <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
            Last updated {{ $article->updated_at->format('M j, Y') }}
        </p>
    @endif

    @if($article->embed)
        <div class="mb-4">
            {!! $article->embed !!}
        </div>
    @endif

    @if($article->content)
        <div class="prose max-w-none dark:prose-invert prose-headings:text-gray-900 dark:prose-headings:text-white prose-video:aspect-video mb-4">
            {!! $article->content !!}
        </div>
    @else
        <div class="text-center py-8 mb-4">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No content available</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                This help article doesn't have any content yet.
            </p>
        </div>
    @endif

    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
        <div>
            @if(Route::has('login'))
                <a href="{{ route('login') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    ← Back to Login
                </a>
            @else
                <a href="/" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    ← Back to Login
                </a>
            @endif
        </div>
        <div>
            <a href="{{ route('filament-help.public.index') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                View All Help Articles →
            </a>
        </div>
    </div>
</div>

