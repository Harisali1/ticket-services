<div x-data="{ showFilter: false }" class="p-6 space-y-6 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold">Agencies List</h1>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.agency.create') }}"
               class="flex items-center gap-2 px-4 py-2 bg-black text-white rounded-md">
                <span>+</span> Create Agency
            </a>

            <button
                @click="showFilter = true"
                class="p-2 border rounded-md hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                     fill="none" stroke="currentColor" stroke-width="1.5"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 4h18M4 8h16M6 12h12M9 16h6M11 20h2"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Overlay -->
    <div
        x-show="showFilter"
        @click="showFilter = false"
        class="fixed inset-0 bg-black bg-opacity-30 z-40"
        x-transition.opacity>
    </div>

    <!-- Filter Sidebar -->
    <div
        x-show="showFilter"
        x-transition:enter="transition transform duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed top-0 right-0 w-80 h-full bg-white border-l z-50 p-6 overflow-y-auto"
    >
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg font-semibold">Filters</h2>
            <button @click="showFilter = false" class="text-xl">&times;</button>
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-600">Agency Name</label>
            <input
                type="text"
                wire:model.defer="filters.agency_name"
                class="w-full border rounded-md p-3 bg-gray-50"
                placeholder="Agency Name">
        </div>

        <div class="mb-4">
            <label class="text-sm text-gray-600">Status</label>
            <select
                wire:model.defer="filters.status"
                class="w-full border rounded-md p-3 bg-gray-50">
                <option value="">Select</option>
                <option value="1">Pending</option>
                <option value="2">Approved</option>
                <option value="3">Suspended</option>
            </select>
        </div>

        <div class="mb-6">
            <label class="text-sm text-gray-600">Created Date</label>
            <div class="grid grid-cols-2 gap-3">
                <input type="date" wire:model.defer="filters.from" class="border rounded-md p-3 bg-gray-50">
                <input type="date" wire:model.defer="filters.to" class="border rounded-md p-3 bg-gray-50">
            </div>
        </div>

        <div class="flex gap-3">
            <button
                wire:click="applyFilters"
                @click="showFilter = false"
                class="flex-1 bg-black text-white py-2 rounded-md">
                Search
            </button>

            <button
                wire:click="resetFilters"
                @click="showFilter = false"
                class="flex-1 border py-2 rounded-md">
                Cancel
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($stats as $label => $count)
            <div class="bg-white border p-5 rounded-lg">
                <p class="text-sm text-gray-500">{{ ucfirst($label) }}</p>
                <p class="text-3xl font-semibold mt-2">{{ $count }}</p>
            </div>
        @endforeach
    </div>

    <!-- Table -->
<select wire:model.live="perPage" class="border p-2 rounded">
    <option value="2">2</option>
    <option value="25">25</option>
    <option value="50">50</option>
</select>

    <div class="overflow-auto border rounded-lg bg-white">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-3"><input type="checkbox"></th>
                    <th class="p-3">Agency Name</th>
                    <th class="p-3">P.IVA</th>
                    <th class="p-3">Address</th>
                    <th class="p-3">Created On</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($agencies as $agency)
                    <tr class="border-b">
                        <td class="p-3"><input type="checkbox"></td>
                        <td class="p-3">{{ $agency->name }}</td>
                        <td class="p-3">{{ $agency->piv }}</td>
                        <td class="p-3">{{ $agency->address }}</td>
                        <td class="p-3">{{ $agency->created_at->format('m/d/Y h:i a') }}</td>
                        <td class="p-3">
                            <span class="{{ $agency->status->color() }}">
                               {{ $agency->status->label() }}
                            </span>
                        </td>
                        <td class="p-3 relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                @click.outside="open = false"
                                class="text-xl px-2 rounded hover:bg-gray-100"
                            >
                                ⋮
                            </button>

                            <!-- Dropdown -->
                            <div
                                x-show="open"
                                x-transition
                                class="absolute right-0 mt-2 w-32 bg-white border rounded-md shadow-lg z-50">
                                <a
                                    href="{{ route('admin.agency.edit', $agency->id) }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    Edit
                                </a>
                                <a
                                    href="{{ route('admin.agency.show', $agency->id) }}"
                                    class="block px-4 py-2 text-sm hover:bg-gray-100">
                                    View Details
                                </a>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-gray-500">
                            No agencies found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        

    </div>
    <div class="mt-4">
        {{ $agencies->links() }}
    </div>
</div>
