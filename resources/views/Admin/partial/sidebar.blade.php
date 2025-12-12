<aside class="bg-black text-white flex flex-col py-6 transition-all duration-300" :class="sidebar ? 'w-64' : 'w-20'">
  <div class="px-6 mb-8" x-show="sidebar">
    <h1 class="text-xl font-semibold">Airline</h1>
  </div>

    <!-- Toggle Button -->
    <button class="text-white px-4 mb-4 focus:outline-none" @click="sidebar = !sidebar">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="#fff" viewBox="0 0 24 24">
        <path d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <!-- Navigation -->
    <nav class="flex flex-col gap-2 px-2">
 <!-- fa-2x -->
      <!-- Active Menu -->
      <div class="flex items-center gap-3 px-3 py-3 bg-gray-600 rounded cursor-pointer">
        <i class="fa fa-tachometer" aria-hidden="true"></i>
        <span x-show="sidebar" class="whitespace-nowrap">Dashboard</span>
      </div>

      <!-- Other Menu -->
        <a href="{{ route('admin.agency.index') }}" class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
          <i class="fa fa-building" aria-hidden="true"></i>
          <span x-show="sidebar" class="whitespace-nowrap">Manage Agencies</span>
        </a>

        <a href="{{ route('admin.airline.index') }}" class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
          <i class="fa fa-plane" aria-hidden="true"></i>
          <span x-show="sidebar" class="whitespace-nowrap">Manage Airline</span>
        </a>

        <a href="{{ route('admin.user.index') }}" class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span x-show="sidebar" class="whitespace-nowrap">User Management</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
          <i class="fa fa-book" aria-hidden="true"></i>
          <span x-show="sidebar" class="whitespace-nowrap">Manage PNR</span>
        </a>


        

        <a href="#" class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
          <i class="fa fa-calendar" aria-hidden="true"></i>
          <span x-show="sidebar" class="whitespace-nowrap">Manage Bookings</span>
        </a>
    </nav>

  </aside>