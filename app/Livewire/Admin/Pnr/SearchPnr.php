<?php

namespace App\Livewire\Admin\Pnr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Pnr;
use App\Models\Admin\Seat;
use Illuminate\Http\Request;
use App\Models\Admin\PassengerType;
use DB;
use Carbon\Carbon;

class SearchPnr extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $trip_type;
    public $departure_id;
    public $arrival_id;
    public $departure_date;
    public $day_minus;
    public $day_plus;
    public $return_departure_id;
    public $return_arrival_id;
    public $return_departure_date;
    public $return_day_minus;
    public $return_day_plus;
    public $perPage = 10;


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
        $this->trip_type = $initialFilters['trip_type'] ?? null;

        $this->departure_id = $initialFilters['departure_id'] ?? null;
        $this->arrival_id = $initialFilters['arrival_id'] ?? null;
        $this->departure_date = $initialFilters['departure_date'] ?? null;
        $this->day_minus = $initialFilters['day_minus'] ?? null;
        $this->day_plus = $initialFilters['day_plus'] ?? null;
        
        $this->return_departure_id = $initialFilters['return_departure_id'] ?? null;
        $this->return_arrival_id = $initialFilters['return_arrival_id'] ?? null;
        $this->return_departure_date = $initialFilters['return_departure_date'] ?? null;
        $this->return_day_minus = $initialFilters['return_day_minus'] ?? null;
        $this->return_day_plus = $initialFilters['return_day_plus'] ?? null;
    }

    public function render()
    {
        
        if($this->day_plus){
            $endDepartureDate = Carbon::parse($this->departure_date)->addDays($this->day_plus)->format('Y-m-d');
        }
        if($this->day_minus){
            $startDepartureDate = Carbon::parse($this->departure_date)->subDays($this->day_minus)->format('Y-m-d');
        }
        if($this->return_day_plus){
            $endReturnDepartureDate = Carbon::parse($this->return_departure_date)->addDays($this->return_day_plus)->format('Y-m-d');
        }
        if($this->return_day_minus){
            $startReturnDepartureDate = Carbon::parse($this->return_departure_date)->subDays($this->return_day_minus)->format('Y-m-d');
        }

        $pnrs = Pnr::withCount(['seats as seat_available' => function ($q) {
                    $q->where('is_sale', 1);
                }])
            ->where('pnr_type', $this->trip_type)
            ->where('departure_id', $this->departure_id)
            ->where('arrival_id', $this->arrival_id)
            ->whereBetween('departure_date', [$startDepartureDate, $endDepartureDate]);

            if($this->trip_type == 'return'){
                $pnrs = $pnrs->where('return_departure_id', $this->return_departure_id)
                        ->where('return_arrival_id', $this->return_arrival_id)
                        ->whereBetween('return_departure_date', [$startReturnDepartureDate, $endReturnDepartureDate]);
            }
 
            $pnrs = $pnrs->with('airline', 'seats')
            ->paginate($this->perPage);

        $passengerTypes = PassengerType::all();

        
        return view('livewire.admin.pnr.search-pnr', compact('pnrs','passengerTypes'));
    }
}


