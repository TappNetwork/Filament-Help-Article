@php
    $componentName = config('filament-help.layout', 'help-layout');
@endphp

{{-- Use component syntax --}}
<x-dynamic-component :component="$componentName" :title="$article->name">
    @include('filament-help::public.show-content')
</x-dynamic-component>
