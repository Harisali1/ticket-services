<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PnrStoreRequest;
use App\Models\Admin\Pnr;
use DB;

class PnrController extends Controller
{
    public function index(){
        return view('Admin.pnr.list');
    }

    public function create(){
        return view('Admin.pnr.add');
    }

    public function store(PnrStoreRequest $request){

        
        $validated = $request->validated();

        DB::beginTransaction();

        try {

            $data = $request->validated();

            // Handle file upload
            if ($request->hasFile('pnr_file')) {
                $data['pnr_file'] = $request->file('pnr_file')->store('pnr-documents', 'public');
            }

            $pnr = Pnr::create($data);

            foreach (range(1, $data['seats']) as $i) {
                $pnr->seats()->create([
                    'price' => 0
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
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
}
