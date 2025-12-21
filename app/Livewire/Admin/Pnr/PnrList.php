<?php

namespace App\Livewire\Admin\Pnr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Pnr;

class PnrList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';


    public $filters = [
        'pnr_no' => '',
        'airline' => '',
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
        $pnrs = Pnr::with('seats', 'airline')
            ->when($this->filters['pnr_no'], fn ($q) =>
                $q->where('pnr_no', 'like', '%' . $this->filters['pnr_no'] . '%')
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
            'all'       => Pnr::count(),
            'pending'   => Pnr::where('status', 1)->count(),
            'approved'  => Pnr::where('status', 2)->count(),
            'suspended' => Pnr::where('status', 3)->count(),
        ];

        return view('livewire.admin.pnr.pnr-list', compact('pnrs', 'stats'));
    }
}
