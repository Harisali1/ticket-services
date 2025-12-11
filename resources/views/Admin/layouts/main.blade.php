<!DOCTYPE html>
<html lang="en">
    @include('Admin.partial.head')
    @yield('styles')
    <body class="bg-gray-100" x-data="{ sidebar: true, profileMenu: false }">
        <div class="flex h-screen">
            <!-- Sidebar -->
            @include('Admin.partial.sidebar')
            <!-- end sidebar -->
            <!-- Main Content -->
            <main class="flex-1">
                <!-- Top Navbar -->
                    @include('Admin.partial.header')
                <!-- Top Navbar -->
                <!-- page content -->   
                    @yield('content')
                <!-- /page content -->
            </main>
            <!-- Main Content -->
        </div>
    </body>
</html>
