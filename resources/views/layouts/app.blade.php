<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GYM and Fitness')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#020617] text-white antialiased">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top,_rgba(249,115,22,0.16),_transparent_25%),radial-gradient(circle_at_bottom_right,_rgba(34,197,94,0.12),_transparent_30%)]">
        @include('components.alerts')
        @yield('content')
    </div>
    @vite(['resources/js/app.js'])
</body>
</html>
