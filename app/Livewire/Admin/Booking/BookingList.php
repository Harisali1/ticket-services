<?php

namespace App\Livewire\Admin\Booking;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Booking;
use DB;

class BookingList extends Component
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

    public function openPutOnSale($pnrId)
    {

       $seats = Seat::where('pnr_id', $pnrId)
            ->selectRaw('
                pnr_id,
                COUNT(*) AS total_seats,
                SUM(CASE WHEN is_available = 0 THEN 1 ELSE 0 END) AS available_seats,
                SUM(CASE WHEN is_sale = 1 THEN 1 ELSE 0 END) AS sale_seats,
                SUM(CASE WHEN is_sold = 1 THEN 1 ELSE 0 END) AS sold_seats
            ')
            ->groupBy('pnr_id')
            ->first();

        $this->selectedPnr = $seats;
        
        $this->selectedPnrId = $pnrId;
        $this->seats = null;
        $this->price = null;

        $this->dispatch('open-put-on-sale-modal');
    }

    public function openCancelCurrentSale($pnrId)
    {

       $seats = Seat::where('pnr_id', $pnrId)
            ->selectRaw('
                pnr_id,
                COUNT(*) AS total_seats,
                SUM(CASE WHEN is_available = 0 THEN 1 ELSE 0 END) AS available_seats,
                SUM(CASE WHEN is_sale = 1 THEN 1 ELSE 0 END) AS sale_seats,
                SUM(CASE WHEN is_sold = 1 THEN 1 ELSE 0 END) AS sold_seats
            ')
            ->groupBy('pnr_id')
            ->first();

        $this->selectedPnr = $seats;
        $this->selectedPnrId = $pnrId;
        $this->comment = null;
        $this->dispatch('open-cancel-current-sale-modal');
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

    public function render()
    {
        $bookings = Booking::query();

        if(auth()->user()->user_type_id != 1){
            $bookings = $bookings->where('created_by', auth()->user()->id);
        }

        $bookings = $bookings->when($this->filters['pnr_no'], fn ($q) =>
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
            'all'       => Booking::count(),
            'reserved'  => Booking::where('status', 1)->count(),
            'ticketed'  => Booking::where('status', 2)->count(),
            'paid'      => Booking::where('status', 3)->count(),
            'abandoned' => Booking::where('status', 4)->count(),
        ];

        return view('livewire.admin.booking.booking-list', compact('bookings', 'stats'));
    }
}
