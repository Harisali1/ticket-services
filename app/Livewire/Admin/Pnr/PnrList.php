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

    public $perPage = 10;
    // Modal data
    public $selectedPnr;
    public $selectedPnrId;
    public $seats;
    public $price;
    public $comment;

    public $filters = [
        'pnr_no' => '',
        'airline' => '',
        'status' => '',
        'from' => '',
        'to' => '',
    ];

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
        $pnrs = Pnr::with('seats', 'airline');

        $all = (clone $pnrs)->count();
        $created   = (clone $pnrs)->where('status', 1)->count();
        $onSale  = (clone $pnrs)->where('status', 2)->count();
        $cancelSale = (clone $pnrs)->where('status', 3)->count();
        $soldOut = (clone $pnrs)->where('status', 4)->count();
        $available = (clone $pnrs)->where('status', 5)->count();

            $pnrs = $pnrs->when($this->filters['pnr_no'], fn ($q) =>
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

        return view('livewire.admin.pnr.pnr-list', compact('pnrs', 'all', 'created', 'onSale', 'cancelSale', 'soldOut', 'available'));
    }
}
