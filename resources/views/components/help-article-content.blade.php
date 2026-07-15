@props(['content'])

@if (filled($content))
    <div {{ $attributes->class(['fi-prose max-w-none']) }}>
        {!! str($content)->sanitizeHtml() !!}
    </div>
@endif
