<?php

namespace App\Livewire\Admin\Payment;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Booking;

class PendingPaymentList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    
    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        $pendingPayment = Booking::where('created_by', auth()->user()->id)
            ->where('is_approved', 0)
            ->where('status', 2)
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.payment.pending-payment-list', compact('pendingPayment'));
    }
}
