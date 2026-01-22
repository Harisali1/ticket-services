<?php

namespace App\Livewire\Admin\Payment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\PaymentUpload;

class PaymentApprovalList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $userId; // 👈 route se aane wali ID

    public $filters = [
        'status' => '',
        'from' => '',
        'to' => '',
    ];

    public $perPage = 10;

    // 🔥 Route parameter receive here
    public function mount($id)
    {
        $this->userId = $id;
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function updatedFilters()
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
        $payments = PaymentUpload::where('created_by', $this->userId) // ✅ ID wise filter
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

        return view('livewire.admin.payment.payment-approval-list', compact('payments'))->layout('Admin.layouts.main');
    }
}
