<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

  <!-- <script src="{{ asset('build/css/tailwind.css') }}"></script> -->
  <!-- <script src="https://unpkg.com/alpinejs" defer></script> -->
  <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>