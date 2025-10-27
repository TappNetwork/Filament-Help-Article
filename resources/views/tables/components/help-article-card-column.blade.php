<div class="w-full h-full flex flex-col items-start justify-start">
    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
        {{ $getRecord()->name }}
    </h3>
    @if($getRecord()->content)
        <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">
            {!! Str::limit(strip_tags($getRecord()->content), 150) !!}
        </p>
    @endif
</div>
