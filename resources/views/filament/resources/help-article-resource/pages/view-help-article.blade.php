<x-filament-panels::page>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="space-y-6">
            @if($this->record->embed)
                <div class="mb-6">
                    {!! $this->record->embed !!}
                </div>
            @endif
            
            @if($this->record->content)
                <div class="prose max-w-none dark:prose-invert prose-headings:text-gray-900 dark:prose-headings:text-white prose-video:aspect-video">
                    {!! $this->record->content !!}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.009-5.824-2.709M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No content available</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        This help article doesn't have any content yet.
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
