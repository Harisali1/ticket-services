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