@php
    $componentName = config('filament-help.layout', 'help-layout');
@endphp

{{-- Use component syntax --}}
<x-dynamic-component :component="$componentName" title="Help Articles">
    @include('filament-help::public.index-content')
</x-dynamic-component>

