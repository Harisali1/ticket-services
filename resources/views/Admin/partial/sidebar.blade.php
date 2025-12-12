<aside 
    class="bg-black text-white flex flex-col py-6 transition-all duration-300"
    :class="sidebar ? 'w-64' : 'w-20'">

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
        <i class="fa fa-tachometer fa-2x" aria-hidden="true"></i>
        <span x-show="sidebar" class="whitespace-nowrap">Dashboard</span>
      </div>

      <!-- Other Menu -->

      <div class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
        <a href="{{ route('admin.agency.index') }}">
        <span x-show="sidebar" class="whitespace-nowrap">Manage Agencies</span>
</a>
      </div>

      <div class="flex items-center gap-3 px-3 py-3 hover:bg-gray-700 rounded cursor-pointer">
        
        <span x-show="sidebar" class="whitespace-nowrap">Manage Bookings</span>
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