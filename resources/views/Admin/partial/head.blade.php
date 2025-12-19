<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    body {
        overflow-x: hidden;
        background-color: #f8f9fa;
    }

    /* Sidebar */
    #sidebar {
        min-height: 100vh;
        background-color: #000;
        color: #fff;
    }

    #sidebar .nav-link {
        color: #fff;
        padding: 15px;
    }

    #sidebar .nav-link.active, 
    #sidebar .nav-link:hover {
        background-color: #6c757d;
        color: #fff;
    }

    #sidebar .nav-link i {
        width: 10px;
        padding: auto;
    }

    /* Quick Stats cards */
    .card-stat {
        text-align: center;
        padding: 1rem;
    }

    .card-stat h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .card-stat p {
        margin: 0;
        font-weight: 500;
    }
</style>
</head>