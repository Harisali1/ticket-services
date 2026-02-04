<?php

namespace App\Livewire\Admin\Pnr;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin\Pnr;
use App\Models\Admin\Seat;
use Illuminate\Http\Request;
use App\Models\Admin\PassengerType;
use App\Models\Admin\Airport;
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
        $today = Carbon::today();

        $departureDate = Carbon::parse($this->departure_date);

        // Days difference from today
        $daysDiff = $today->diffInDays($departureDate, false);

        // Max allowed minus logic
        $maxMinus = match (true) {
            $daysDiff <= 0 => 0,   // today
            $daysDiff === 1 => 1,  // tomorrow
            $daysDiff === 2 => 2,  // day after tomorrow
            default => 3,          // after that
        };

        // PLUS days (same as before)
        $endDepartureDate = $departureDate
            ->copy()
            ->addDays($this->day_plus ?? 0)
            ->format('Y-m-d');

        // MINUS days (controlled)
        $requestedMinus = $this->day_minus ?? 0;
        $finalMinus = min($requestedMinus, $maxMinus);

        $startDepartureDate = $departureDate
            ->copy()
            ->subDays($finalMinus)
            ->format('Y-m-d');

        /*
        |--------------------------------------------------------------------------
        | RETURN DATE RANGE (IF RETURN TRIP)
        |--------------------------------------------------------------------------
        */

        if ($this->trip_type === 'return' && $this->return_departure_date) {

            $returnDepartureDate = Carbon::parse($this->return_departure_date);

            $returnDaysDiff = $today->diffInDays($returnDepartureDate, false);

            $maxReturnMinus = match (true) {
                $returnDaysDiff <= 0 => 0,
                $returnDaysDiff === 1 => 1,
                $returnDaysDiff === 2 => 2,
                default => 3,
            };

            $endReturnDepartureDate = $returnDepartureDate
                ->copy()
                ->addDays($this->return_day_plus ?? 0)
                ->format('Y-m-d');

            $finalReturnMinus = min($this->return_day_minus ?? 0, $maxReturnMinus);

            $startReturnDepartureDate = $returnDepartureDate
                ->copy()
                ->subDays($finalReturnMinus)
                ->format('Y-m-d');
        }

        if ($this->trip_type === 'return') {
            $outbounds = Pnr::withCount([
                'seats as seat_available' => fn ($q) => $q->where('is_sale', 1)
            ])
            ->where('departure_id', $this->departure_id)
            ->where('arrival_id', $this->arrival_id)
            ->whereBetween('departure_date', [$startDepartureDate, $endDepartureDate])
            ->with('airline', 'seats')
            ->get();

            $returns = Pnr::withCount([
                'seats as seat_available' => fn ($q) => $q->where('is_sale', 1)
            ])
            ->where('departure_id', $this->return_departure_id)
            ->where('arrival_id', $this->return_arrival_id)
            ->whereBetween('departure_date', [$startReturnDepartureDate, $endReturnDepartureDate])
            ->with('airline', 'seats')
            ->get();

            $pnrs = [];

            foreach ($outbounds as $outbound) {
                foreach ($returns as $return) {
                    if (
                        $outbound->arrival_id === $return->departure_id &&
                        $outbound->departure_date < $return->departure_date
                    ) {
                        $pnrs[] = [
                            'outbound' => $outbound,
                            'return'   => $return,
                        ];
                    }
                }
            }

        } else {

            $pnrs = Pnr::withCount([
                'seats as seat_available' => fn ($q) => $q->where('is_sale', 1)
            ])
            ->where('departure_id', $this->departure_id)
            ->where('arrival_id', $this->arrival_id)
            ->whereBetween('departure_date', [$startDepartureDate, $endDepartureDate])
            ->with('airline', 'seats')
            ->paginate($this->perPage);
        }

        $passengerTypes = PassengerType::all();
        $type = $this->trip_type;

        return view('livewire.admin.pnr.search-pnr', compact(
            'pnrs',
            'passengerTypes',
            'type'
        ));

    }
}


