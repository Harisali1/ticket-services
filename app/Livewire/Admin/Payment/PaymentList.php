<?php

namespace App\Livewire\Admin\Payment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Booking;
use App\Models\Admin\PaymentUpload;

class PaymentList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $filters = [
        'title' => '',
        'status' => '',
        'from' => '',
        'to' => '',
    ];

    public $perPage = 10;

    public function updatedPerPage()
    {
        $this->resetPage();
    }

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
        $payments = PaymentUpload::where('created_by', auth()->user()->id);

        $payments = $payments->when($this->filters['status'] !== '', fn ($q) =>
            $q->where('is_approved', $this->filters['status'])
        )
        ->when($this->filters['from'], fn ($q) =>
            $q->whereDate('created_at', '>=', $this->filters['from'])
        )
        ->when($this->filters['to'], fn ($q) =>
            $q->whereDate('created_at', '<=', $this->filters['to'])
        )
        ->latest()
        ->paginate($this->perPage);

        return view('livewire.admin.payment.payment-list', compact('payments'));
    }
}
