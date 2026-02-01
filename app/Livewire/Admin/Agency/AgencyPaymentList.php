<?php

namespace App\Livewire\Admin\Agency;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Agency;

class AgencyPaymentList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'agency_name' => '',
        'created_by' => '',
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
        $agencies = Agency::with('user');
        
        $agencies = $agencies
        ->when($this->filters['created_by'], fn ($q) =>
            $q->where('user_id', $this->filters['created_by'])
        )
        ->when($this->filters['status'] !== '', fn ($q) =>
            $q->where('status', $this->filters['status'])
        )
        ->when($this->filters['from'], fn ($q) =>
            $q->whereDate('created_at', '>=', $this->filters['from'])
        )
        ->when($this->filters['to'], fn ($q) =>
            $q->whereDate('created_at', '<=', $this->filters['to'])
        );

        $agencies = $agencies->latest()
            ->paginate($this->perPage);

        $agency = Agency::where('status', 2)->get();        
        return view('livewire.admin.agency.agency-payment-list', compact('agencies','agency'));
    }
}
