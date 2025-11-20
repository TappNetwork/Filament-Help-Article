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

        {{-- Only load Filament assets if in a Filament context (authenticated) --}}
        @if(auth()->check() && class_exists(\Filament\Facades\Filament::class))
            @filamentStyles
        @endif
        
        @vite(config('filament-help.css', ['resources/css/app.css']))
        @if(config('filament-help.theme'))
            @vite([config('filament-help.theme')])
        @endif
    </head>

    <body class="font-sans antialiased">
        <div class="bg-white">
            <div class="relative isolate pt-14">
                <div class="absolute inset-x-0 overflow-hidden -top-40 -z-10 transform-gpu blur-3xl sm:-top-80" aria-hidden="true">
                    <div class="relative left-[calc(50%-11rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-gradient-to-tr from-blue-300 to-blue-500 opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                </div>
                
                <div class="min-h-screen flex flex-col sm:justify-center items-center py-12">
                    <div class="mt-4 mb-4">
                        <a href="/" class="block">
                            @if(file_exists(public_path('logo.png')))
                                <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" class="h-16 w-auto max-w-xs">
                            @else
                                <x-application-logo class="h-16 w-auto fill-current text-gray-500" />
                            @endif
                        </a>
                    </div>

                    <div class="w-full max-w-full sm:max-w-5xl mt-6 mx-4 mb-4 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                        {{ $slot }}
                    </div>
                </div>

                <div class="absolute inset-x-0 top-[calc(100%-13rem)] -z-10 transform-gpu overflow-hidden blur-3xl sm:top-[calc(100%-30rem)]" aria-hidden="true">
                    <div class="relative left-[calc(50%+3rem)] aspect-[1155/678] w-[36.125rem] -translate-x-1/2 bg-gradient-to-tr from-red-500 to-red-700 opacity-30 sm:left-[calc(50%+36rem)] sm:w-[72.1875rem]" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                </div>
            </div>
        </div>

        {{-- Only load Filament scripts if in a Filament context (authenticated) --}}
        @if(auth()->check() && class_exists(\Filament\Facades\Filament::class))
            @filamentScripts
        @endif
        
        @vite('resources/js/app.js')
    </body>
</html>

