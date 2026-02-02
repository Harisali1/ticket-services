<?php

namespace App\Livewire\Admin\Pnr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Pnr;
use App\Models\Admin\Seat;
use DB;

class PnrList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 50;
    // Modal data
    public $selectedPnr;
    public $selectedPnrId;
    public $seats;
    public $price;
    public $comment;

    public $filters = [
        'pnr_no' => '',
        'departure' => '',
        'arrival' => '',
        'status' => '',
    ];

    protected $queryString = [
        'filters.status' => ['except' => '']
    ];

    public function mount()
    {
        if (request()->has('status')) {
            $this->filters['status'] = request('status');
        }
    }

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

    public function filterStatus($status)
    {
        $this->filters['status'] = ($status == 0) ? '' : $status;
    }

    public function render()
    {
        // dd($this->filters);
        $pnrs = Pnr::with('seats', 'airline');

        $all = (clone $pnrs)->count();
        $created   = (clone $pnrs)->where('status', 1)->count();
        $onSale  = (clone $pnrs)->where('status', 2)->count();
        $cancelSale = (clone $pnrs)->where('status', 3)->count();
        $soldOut = (clone $pnrs)->where('status', 4)->count();
        $available = (clone $pnrs)->where('status', 5)->count();

            $pnrs = $pnrs->when($this->filters['pnr_no'], fn ($q) =>
                $q->where('ref_no', 'like', '%' . $this->filters['pnr_no'] . '%')
            )
            ->when($this->filters['status'] !== '', fn ($q) =>
                $q->where('status', $this->filters['status'])
            )
            ->when($this->filters['departure'], fn ($q) =>
                $q->whereBetween('departure_date', [$this->filters['departure'], $this->filters['departure']])
            )
            ->when($this->filters['arrival'], fn ($q) =>
                $q->whereBetween('arrival_date', [$this->filters['arrival'], $this->filters['arrival']])
            )
            ->orderBy('departure_date', 'ASC')
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.pnr.pnr-list', compact('pnrs', 'all', 'created', 'onSale', 'cancelSale', 'soldOut', 'available'));
    }
}
