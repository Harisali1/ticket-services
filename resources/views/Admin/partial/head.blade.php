<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>
  <link href="{{ asset('css/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
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

        /* Header icon button */
    .icon-btn {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #212529;
        transition: all .2s ease;
    }

    .icon-btn:hover {
        background: #e9ecef;
    }

    /* Profile avatar */
    .profile-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0d6efd, #0b5ed7);
        color: #fff;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Language flags */
    .language-flag img {
        width: 20px;
        height: 14px;
        border-radius: 2px;
        transition: transform .2s ease;
    }

    .language-flag:hover img {
        transform: scale(1.1);
    }

.fixed-footer {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #fff;        /* footer background */
        padding: 10px 0;
        border-top: 1px solid #ddd;
        z-index: 999;
    }

    .sidebar-position{
        z-index: 9999;
    }

    .notification-dropdown{
        max-height: 200px;
        overflow-y: auto;
        padding-right: 4px;
    }

    /* Scrollbar styling (Chrome, Edge) */
    .notification-dropdown::-webkit-scrollbar{
        width: 6px;
    }

    .notification-dropdown::-webkit-scrollbar-thumb{
        background: #c1c1c1;
        border-radius: 10px;
    }

    .notification-dropdown::-webkit-scrollbar-track{
        background: transparent;
    }

    .noti-text{
        background: #0d6efd;
        color: white;
        margin-bottom: 2px;
    }

    .noti-text dev{
        color: white;
        margin-bottom: 2px;
    }

    .blink-badge {
        animation: blink 2s infinite;
    }

    @keyframes blink {
        0%, 50%, 100% { opacity: 1; }
        25%, 75% { opacity: 0; }
    }
    .dropdown.show .blink-badge {
        animation: none;
    }

    /* responsive start here */

    /* Sidebar mobile responsive */
    .sidebar-mobile{
        width:260px;
        min-height:100vh;
    }

    @media (max-width:768px){
        .fixed-footer{
            position: relative;
        }
        .sidebar-mobile{
            position:fixed;
            top:0;
            left:-260px;
            height:100%;
            z-index:1050;
            transition:0.3s ease;
        }

        .sidebar-mobile.active{
            left:0;
        }

        .sidebar-overlay{
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.5);
            z-index:1040;
            display:none;
        }

        .sidebar-overlay.active{
            display:block;
        }
        .navbar{
            min-height:60px;
        }

        .profile-avatar{
            width:32px;
            height:32px;
            font-size:14px;
        }

        .icon-btn{
            font-size:16px;
        }

        .language-flag img{
            width:18px;
        }

        .notification-dropdown{
            width:280px;
            max-width:90vw;
        }
        .table-responsive{
            overflow-x:auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-scroll{
            min-width:1100px; /* adjust according to columns */
        }

        .pnr-shadow-box img{
            width:25px !important;
            height:25px !important;
        }
    }
    

</style>
</head>