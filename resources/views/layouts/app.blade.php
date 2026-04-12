<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'WolfNet — Stream movies and series in Tunisia.')">
    <title>@yield('title', config('app.name', 'WolfNet'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="font-sans antialiased bg-gray-950 text-gray-100 min-h-screen">

    @include('layouts.navigation')

    {{-- Flash messages --}}
    @if(session('success') || session('error') || session('warning') || session('info'))
        <div class="max-w-7xl mx-auto px-4 pt-4 space-y-2">
            @if(session('success'))
                <div class="bg-green-800/60 border border-green-600 text-green-200 px-4 py-3 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-800/60 border border-red-600 text-red-200 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('warning'))
                <div class="bg-yellow-800/60 border border-yellow-500 text-yellow-200 px-4 py-3 rounded-lg text-sm">
                    {{ session('warning') }}
                </div>
            @endif
            @if(session('info'))
                <div class="bg-blue-800/60 border border-blue-500 text-blue-200 px-4 py-3 rounded-lg text-sm">
                    {{ session('info') }}
                </div>
            @endif
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
