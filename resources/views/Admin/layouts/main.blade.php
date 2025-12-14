<!DOCTYPE html>
<html lang="en">
    @include('Admin.partial.head')
    @yield('styles')
    @livewireStyles
    <body class="bg-gray-100" x-data="{ sidebar: true, profileMenu: false }">
        <div class="flex">
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
        @include('Admin.partial.footer')
    </body>
    @include('Admin.partial.script')
    @yield('scripts')
    @livewireScripts
</html>
