<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> --}}
    {{-- <meta name="mobile-web-app-capable" content="yes"> --}}
    <link rel="shortcut icon" href="{{ asset('logo.png') }}" type="image/x-icon">

    <!-- PWA  -->
    {{-- <meta name="theme-color" content="#6777ef" /> --}}
    <link rel="apple-touch-icon" href="{{ asset('logo.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Laravel Inertia & Vite -->
    @routes
    @vite(['resources/js/app.js'])
    @inertiaHead
</head>

<body>
    @inertia

    {{-- <script src="{{ asset('sw.js') }}"></script> --}}
</body>

</html>
