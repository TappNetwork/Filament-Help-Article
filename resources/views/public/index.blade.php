@php
    $layoutConfig = config('filament-help.help_layout', 'help-layout');
    // Use the help layout config, fallback to guest_layout for backwards compatibility
    if ($layoutConfig === 'help-layout' || !$layoutConfig) {
        $layoutConfig = config('filament-help.help_layout', 'help-layout');
    }
    
    // If it's a view path like 'layouts.guest', convert to component name
    $componentName = $layoutConfig;
    if (str_contains($layoutConfig, '.')) {
        $parts = explode('.', $layoutConfig);
        $lastPart = end($parts);
        // Convert 'guest' to 'guest-layout' (matching GuestLayout component class)
        $componentName = \Illuminate\Support\Str::kebab($lastPart) . '-layout';
    }
@endphp

{{-- Use component syntax --}}
<x-dynamic-component :component="$componentName" title="Help Articles">
    @include('filament-help::public.index-content')
</x-dynamic-component>

