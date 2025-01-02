<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    @vite(['resources/css/app.css'])
    @routes
    @inertiaHead
</head>

<body class="dark:bg-black dark:text-white/50">
    @inertia
</body>

</html>
