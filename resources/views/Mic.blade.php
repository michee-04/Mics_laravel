<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - @yield('title') </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        {{-- Boostrap de css --}}
        <link rel="stylesheet" href="{{ asset('Mics/app.css') }}">

    </head>
    <body>

        {{-- Barre de navigation --}}
        @include('navbar/barre')

        {{-- Tous les fichiers hériterons de cette page  --}}
        @yield('contenu')

        {{-- JS --}}
        @include('script')
        
    </body>
</html>

