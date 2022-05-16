<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="application-name" content="{{ config('app.name') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    {{-- Styles --}}
    @livewireStyles
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    {{-- Scripts --}}
    @livewireScripts
    <script src="{{ mix('js/app.js') }}" defer></script>
    @stack('scripts')
</head>
<body class="h-full antialiased">
{{ $slot ?? null }}
</body>
</html>
