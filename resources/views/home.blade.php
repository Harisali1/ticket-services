<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100" x-data="{ sidebar: true, profileMenu: false }">

<div class="flex h-screen">

  <!-- Sidebar -->
  <aside 
    class="bg-black text-white flex flex-col py-6 transition-all duration-300"
    :class="sidebar ? 'w-64' : 'w-20'"
  >

    <!-- Brand -->
    <div class="px-6 mb-8" x-show="sidebar">
      <h1 class="text-xl font-semibold">Airline</h1>
    </div>

    <!-- Toggle Button -->
    <button 
      class="text-white px-4 mb-4 focus:outline-none"
      @click="sidebar = !sidebar"
    >
      <!-- Icon -->
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="#fff" viewBox="0 0 24 24">
        <path d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <!-- Navigation -->
    <nav class="flex flex-col gap-2 px-2">

      <!-- Active Menu -->
      <div class="flex items-center gap-3 px-3 py-3 bg-gray-600 rounded cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="#fff" viewBox="0 0 24 24">
          <path d="M3 3h8v8H3zM13 3h8v8h-8zM3 13h8v8H3zM13 13h8v8h-8z"/>
        </svg>

        <span x-show="sidebar" class="whitespace-nowrap">Dashboard</span>
      </div>

      <!-- Other Menu -->
      <div class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="#fff" viewBox="0 0 24 24">
          <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>

        <span x-show="sidebar" class="whitespace-nowrap">Manage Bookings</span>
      </div>

      <div class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="#fff" viewBox="0 0 24 24">
          <path d="M4 6h16M4 12h16M4 18h16"/>
        </svg>

        <span x-show="sidebar" class="whitespace-nowrap">Manage Agencies</span>
      </div>

        <div class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="#fff" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

            <span x-show="sidebar" class="whitespace-nowrap">Manage PNR</span>
        </div>
          
        <div class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="#fff" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

            <span x-show="sidebar" class="whitespace-nowrap">Manage Airline</span>
        </div>

        <div class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 flex-shrink-0" fill="#fff" viewBox="0 0 24 24">
            <path d="M4 6h16M4 12h16M4 18h16"/>
            </svg>

            <span x-show="sidebar" class="whitespace-nowrap">User Management</span>
        </div>
    </nav>

  </aside>

  <!-- Main Content -->
  <main class="flex-1">

    <!-- Top Navbar -->
    <header class="flex items-center justify-between bg-white px-6 py-4 border-b">

      <!-- Title -->
      <h2 class="text-lg font-semibold">Airline</h2>

      <!-- Search Field -->
      <div class="flex items-center w-1/3 border rounded-lg px-3 py-2">
        <input type="text" placeholder="Search" class="w-full outline-none text-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-500" fill="none" 
             viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 103.6 3.6a7.5 7.5 0 0013.05 13.05z"/>
        </svg>
      </div>

      <!-- Profile Dropdown -->
      <div class="relative">
        <div 
          class="w-10 h-10 bg-gray-700 text-white rounded-full flex items-center justify-center text-sm font-semibold cursor-pointer"
          @click="profileMenu = !profileMenu"
        >
          JD
        </div>

        <!-- Dropdown Menu -->
        <div 
          x-show="profileMenu"
          @click.outside="profileMenu = false"
          class="absolute right-0 mt-2 w-40 bg-white text-black rounded shadow-lg py-2 z-50"
        >
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
          <a href="#" class="block px-4 py-2 hover:bg-gray-100">Logout</a>
          <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle block px-4 py-2 hover:bg-gray-100" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                  {{ Auth::user()->name }}
              </a>

              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item block px-4 py-2 hover:bg-gray-100" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div>
          </li>
          
        </div>
      </div>

    </header>

    <!-- Content -->
    <div class="p-10">

      <h3 class="text-xl font-semibold mb-8">Quick Stats</h3>

      <!-- Stats Row -->
      <div class="flex gap-2 flex-wrap">

            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">100</div>
            <div class="text-gray-500 mt-1">Reserved</div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">40</div>
            <div class="text-gray-500 mt-1">Remaining</div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">30</div>
            <div class="text-gray-500 mt-1">Ticketed</div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">30</div>
            <div class="text-gray-500 mt-1">Abandoned</div>
            </div>

            <!-- Card 5 -->
            <div class="bg-white rounded-lg shadow p-8 w-48 text-center">
            <div class="text-3xl font-semibold text-gray-700">50</div>
            <div class="text-gray-500 mt-1">Completed</div>
            </div>

        </div>


    </div>

  </main>

</div>

</body>
</html>
