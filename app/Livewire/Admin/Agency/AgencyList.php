<?php

namespace App\Livewire\Admin\Agency;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Agency;

class AgencyList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';
    // protected function paginationView()
    // {
    //     return 'components.custom-pagination';
    // }

    public $filters = [
        'agency_name' => '',
        'status' => '',
        'from' => '',
        'to' => '',
    ];

    public $perPage = 2;

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    // Reset page when filters change
    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset('filters');
        $this->resetPage();
    }

    public function render()
    {
        $agencies = Agency::query()
            ->when($this->filters['agency_name'], fn ($q) =>
                $q->where('name', 'like', '%' . $this->filters['agency_name'] . '%')
            )
            ->when($this->filters['status'] !== '', fn ($q) =>
                $q->where('status', $this->filters['status'])
            )
            ->when($this->filters['from'], fn ($q) =>
                $q->whereDate('created_at', '>=', $this->filters['from'])
            )
            ->when($this->filters['to'], fn ($q) =>
                $q->whereDate('created_at', '<=', $this->filters['to'])
            )
            ->latest()
            ->paginate($this->perPage);

        $stats = [
            'all'       => Agency::count(),
            'pending'   => Agency::where('status', 1)->count(),
            'approved'  => Agency::where('status', 2)->count(),
            'suspended' => Agency::where('status', 3)->count(),
        ];

        return view('livewire.admin.agency.agency-list', compact('agencies', 'stats'));
    }
}
