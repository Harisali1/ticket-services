<?php

namespace App\Livewire\Admin\Agency;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\PaymentUpload;

class AgencyPaymentList extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'agency_name' => '',
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
        $paymentUploads = PaymentUpload::with('user');
        
        $paymentUploads = $paymentUploads->when($this->filters['agency_name'], fn ($q) =>
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
        );

        $paymentUploads = $paymentUploads->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.agency.agency-payment-list', compact('paymentUploads'));
    }
}
