<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PnrStoreRequest;
use App\Models\Admin\Pnr;
use App\Models\Admin\Seat;
use App\Models\Admin\AirLine;
use App\Models\Admin\Airport;
use DB;

class PnrController extends Controller
{
    public function index(){

        return view('Admin.pnr.list');
    }

    public function create(){
        $airlines = AirLine::where('status', 1)->limit(10)->get();
        $airports = Airport::where('status', 1)->limit(10)->get();
        return view('Admin.pnr.add', compact('airlines','airports'));
    }

    public function store(PnrStoreRequest $request){

        $validated = $request->validated();

        DB::beginTransaction();

        try {

            $data = $request->validated();

            $airlineCode = AirLine::find($data['airline_id']);
            $departureCode = Airport::find($data['departure_id']);
            $arrivalCode = Airport::find($data['arrival_id']);
            $pnrId = DB::table('pnrs')->orderBy('id', 'desc')->value('id');

            $data['pnr_no'] = $airlineCode->code.$departureCode->code.$arrivalCode->code.$pnrId+1;
            // Handle file upload
            if ($request->hasFile('pnr_file')) {
                $data['pnr_file'] = $request->file('pnr_file')->store('pnr-documents', 'public');
            }

            $pnr = Pnr::create($data);

            foreach (range(1, $data['seats']) as $key => $i) {
                $pnr->seats()->create([
                    'is_available' => 1,
                    'price' => 0
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pnr created successfully',
            ], 201);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function show(Agency $agency){
        $agency = Agency::with('user')->find($agency->id);
        return view('Admin.agency.show', compact('agency'));
    }

    public function edit(Agency $agency){
        $agency = Agency::with('user')->find($agency->id);
        return view('Admin.agency.edit', compact('agency'));
    }

    public function seatStore(Request $request){
        
        $updated = Seat::where('pnr_id', $request->pnr_id)
            ->where('is_available', 1)
            ->where('is_sale', 0)
            ->orderBy('id') // or seat_no
            ->limit((int) $request->seats)
            ->update([
                'is_sale' => 1,
                'price' => $request->price,
                'is_available' => 0,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Seats put on sale successfully',
            ], 201);
    }

    public function seatCancel(Request $request){

        $updated = Seat::where('pnr_id', $request->pnr_id)
            ->where('is_sold', 0)
            ->where('is_sale', 1)
            ->update([
                'is_cancel' => 1,
                'comment' => $request->comment,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Cancel current sale successfully',
            ], 201);
    }
}
