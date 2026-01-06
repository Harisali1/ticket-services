<?php

namespace App\Livewire\Admin\Pnr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Pnr;
use App\Models\Admin\Seat;
use Illuminate\Http\Request;
use DB;

class SearchPnr extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $departure_id;
    public $arrival_id;
    public $departure_date;
    public $arrival_date;
    public $trip_type;
    public $perPage = 2;


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

    public function mount($initialFilters = [])
    {
        $this->departure_id = $initialFilters['departure_id'] ?? null;
        $this->arrival_id = $initialFilters['arrival_id'] ?? null;
        $this->departure_date = $initialFilters['departure_date'] ?? null;
        $this->arrival_date = $initialFilters['arrival_date'] ?? null;
        $this->trip_type = $initialFilters['trip_type'] ?? null;
    }

    public function render()
    {
        
        $pnrs = Pnr::withCount(['seats as seat_available' => function ($q) {
                    $q->where('is_sale', 1);
                }])
            ->where('departure_id', $this->departure_id)
            ->where('arrival_id', $this->arrival_id)
            ->where('pnr_type', $this->trip_type)
            ->whereDate('departure_date', $this->departure_date);
            if($this->trip_type == 'return'){
                $pnrs = $pnrs->whereDate('arrival_date', $this->arrival_date);
            }
        $pnrs = $pnrs->with('airline', 'seats')
            ->paginate($this->perPage);

        
        return view('livewire.admin.pnr.search-pnr', compact('pnrs'));
    }
}


