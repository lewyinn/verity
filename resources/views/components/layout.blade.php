<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('storage/Logo Verity.png') }}">
    <title>Verity | Website Portal Berita terupdate</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    <x-navbar></x-navbar>

    <main>
        {{ $slot }}
    </main>

    <x-footer></x-footer>
</body>
</html>
