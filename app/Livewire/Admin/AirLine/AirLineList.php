<?php

namespace App\Livewire\Admin\AirLine;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\AirLine;

class AirLineList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $filters = [
        'name' => '',
        'code' => '',
        'status' => '',
        'from' => '',
        'to' => '',
    ];

    public $perPage = 10;

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
        $airlines = AirLine::query()
            ->when($this->filters['name'], fn ($q) =>
                $q->where('name', 'like', '%' . $this->filters['name'] . '%')
            )
            ->when($this->filters['code'], fn ($q) =>
                $q->where('code', 'like', '%' . $this->filters['code'] . '%')
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
            'all'       => AirLine::count(),
            'active'   => AirLine::where('status', 1)->count(),
            'deactive'  => AirLine::where('status', 2)->count(),
        ];

        return view('livewire.admin.airline.airline-list', compact('airlines', 'stats'));
    }
}
