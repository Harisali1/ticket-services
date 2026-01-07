<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PnrStoreRequest;
use App\Models\Admin\Pnr;
use App\Models\Admin\Seat;
use App\Models\Admin\AirLine;
use App\Models\Admin\Airport;
use App\Models\Admin\Baggage;
use App\Models\Admin\PassengerType;
use App\Models\Admin\PnrPassenger;
use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;
use Carbon\Carbon;

class PnrController extends Controller
{
    public function index(){

        return view('Admin.pnr.list');
    }

    public function create(){
        $airlines = AirLine::where('status', 1)->limit(10)->get();
        $airports = Airport::where('status', 1)->limit(10)->get();
        $baggages = Baggage::where('status', 1)->limit(10)->get();
        $passengerTypes = PassengerType::all();
        return view('Admin.pnr.add', compact('airlines','airports','passengerTypes'));
    }

    public function store(PnrStoreRequest $request){

        $validated = $request->validated();

        DB::beginTransaction();

        try {
            $returnDuration=0;
            $departure = $request->departure_date .' '. $request->departure_time_hour.':'.$request->departure_time_minute;
            $arrival = $request->arrival_date .' '. $request->arrival_time_hour.':'.$request->arrival_time_minute;
            $start = Carbon::createFromFormat('Y-m-d H:i', $departure);
            $end   = Carbon::createFromFormat('Y-m-d H:i', $arrival);
            $diff = $start->diff($end);

            if($request->pnr_type == 'return'){
                $return_departure = $request->return_departure_date .' '. $request->return_departure_time_hour.':'.$request->return_departure_time_minute;
                $return_arrival = $request->return_arrival_date .' '. $request->return_arrival_time_hour.':'.$request->return_arrival_time_minute;
                $start = Carbon::createFromFormat('Y-m-d H:i', $return_departure);
                $end   = Carbon::createFromFormat('Y-m-d H:i', $return_arrival);
                $returnDiff = $start->diff($end);
                if($returnDiff->d != 0){
                    $returnDuration = $returnDiff->d.'d '.$returnDiff->h.'h '.$returnDiff->i.'m';
                }else{
                    $returnDuration = $returnDiff->h.'h '.$returnDiff->i.'m';
                }
            }

            if($diff->d != 0){
                $duration = $diff->d.'d '.$diff->h.'h '.$diff->i.'m';
            }else{
                $duration = $diff->h.'h '.$diff->i.'m';
            }

            $data = [
                'pnr_type' => $request->pnr_type,
                'flight_no' => $request->flight_no,
                'air_craft' => $request->air_craft,
                'class' => $request->class,
                'baggage' => $request->baggage,
                'departure_id' => $request->departure_id,
                'arrival_id' => $request->arrival_id,
                'airline_id' => $request->airline_id,
                'duration' => $duration,
                'departure_date' => $request->departure_date,
                'departure_time' => $request->departure_time_hour.':'.$request->departure_time_minute,
                'arrival_date' => $request->arrival_date,
                'arrival_time' => $request->arrival_time_hour.':'.$request->arrival_time_minute,
                'seats' => $request->seats,
                'price' => $request->price,
            ];

            if($request->pnr_type == 'return'){
                $data['return_duration'] = $returnDuration;
                $data['return_departure_id'] = $request->return_departure_id;
                $data['return_arrival_id'] = $request->return_arrival_id;
                $data['return_airline_id'] = $request->return_airline_id;
                $data['return_departure_date'] = $request->return_departure_date;
                $data['return_arrival_date'] = $request->return_arrival_date;
                $data['return_departure_time'] = $request->return_departure_time_hour.':'.$request->return_departure_time_minute;
                $data['return_arrival_time'] = $request->return_arrival_time_hour.':'.$request->return_arrival_time_minute;
            }

            $airlineCode = AirLine::find($data['airline_id']);
            $departureCode = Airport::find($data['departure_id']);
            $arrivalCode = Airport::find($data['arrival_id']);
            $pnrId = DB::table('pnrs')->orderBy('id', 'desc')->value('id');
            $data['pnr_no'] = $airlineCode->code.$departureCode->code.$arrivalCode->code.$pnrId+1;
            $data['created_by'] = auth()->user()->id;

            // $data = collect($data)->except('baggage_id')->toArray();

            $pnr = Pnr::create($data);

            // // $pnr->baggages()->sync($request->baggage_id);

            foreach (range(1, $data['seats']) as $key => $i) {
                $pnr->seats()->create([
                    'is_available' => 1,
                    'price' => 0
                ]);
            }

            foreach($request->passenger_prices as $key => $pnrPassenger){
                PnrPassenger::create([
                    'pnr_id' => 1,
                    'passenger_type_id' => $key,
                    'price' => $pnrPassenger,
                ]);
            }

            if(isset($request->put_on_sale)){
                Seat::where('pnr_id', $pnr->id)
                ->where('is_available', 1)
                ->where('is_sale', 0)
                ->orderBy('id') // or seat_no
                ->limit((int) $data['seats'])
                ->update([
                    'is_sale' => 1,
                    'is_available' => 0,
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

    public function uploadPnr(){
        return view('Admin.pnr.upload-pnr');
    }

    public function uploadPnrSubmit(Request $request){
        $request->validate([
            'pnr_file' => 'required|file|mimes:csv,txt|max:5120', // 5MB
        ]);

        try {
            // 1️ Get file
            $file = $request->file('pnr_file');

            // 2️ Generate unique filename
            $fileName = 'pnr_' . time() . '_' . Str::random(6) . '.csv';

            // 3️ Store file
            $path = $file->storeAs('uploads/pnr', $fileName, 'public');

            // 4️ Read CSV
            $fullPath = storage_path('app/public/' . $path);
            $rows = array_map('str_getcsv', file($fullPath));

            if (count($rows) <= 1) {
                return response()->json([
                    'code' => 2,
                    'message' => 'CSV file is empty'
                ], 422);
            }

            // 5️ Remove header row
            $header = array_shift($rows);

            $insertData = [];

            foreach ($rows as $index => $row) {
                if (count($row) < count($header)) {
                    continue; // skip invalid rows
                }
                $departure = Airport::where('code', $row[0])->first();
                $arrival = Airport::where('code', $row[1])->first();
                $airline = AirLine::where('code', $row[2])->first();
                // Example mapping (adjust columns as needed)
                $insertData[] = [
                    'departure_id'   => $departure->id ?? null,
                    'arrival_id'    => $arrival->id ?? null,
                    'airline_id'      => $airline->id ?? null,
                    'seats'  => $row[3] ?? null,
                    'departure_date'  => $row[4] ?? null,
                    'departure_time'  => $row[5] ?? null,
                    'arrival_date'  => $row[6] ?? null,
                    'arrival_time'  => $row[7] ?? null,
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ];
            }

            // 6️ Insert into DB (optional)
            if (!empty($insertData)) {
                DB::table('pnrs')->insert($insertData);
            }

            return response()->json([
                'code' => 1,
                'message' => 'PNR CSV uploaded successfully',
                'total_rows' => count($insertData)
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'code' => 2,
                'message' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
