<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="application-name" content="{{ config('app.name') }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        @filamentStyles
        @vite(config('filament-help.help_layout_css', ['resources/css/app.css']))
        @if(config('filament-help.help_layout_theme_css'))
            @vite([config('filament-help.help_layout_theme_css')])
        @endif
    </head>

    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="mt-4 mb-4">
                <a href="{{ config('filament-help.help_layout_logo_url', '/') }}" class="block">
                    @if(file_exists(public_path('logo.png')))
                        <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" class="h-16 w-auto max-w-xs">
                    @else
                        <x-application-logo class="h-16 w-auto fill-current text-gray-500" />
                    @endif
                </a>
            </div>

            <div class="max-w-full sm:max-w-5xl mt-6 mx-4 mb-4 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>

