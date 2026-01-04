<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Airport;
use App\Models\Admin\AirLine;
use App\Models\Admin\Baggage;

class DataListController extends Controller
{
    public function searchAirport(Request $request){
        $airport=[];
        $selectAirport = Airport::where(function ($query) use($request){
            $query->where('code','like',"%$request->term%");
                // ->OrWhere('name','like',"%$request->term%");
        })
        ->where('status', 1);

        $selectAirport = $selectAirport->orderby('id','desc')->limit(10)->get(['id','name','code']);
        if ($selectAirport) {
            foreach ($selectAirport as $val) {
                $airport[] = array('id' => $val->id, 'label' => $val->name ."($val->code)");
            }
        }
        return $airport;
    }

    public function searchAirLine(Request $request){
        $airline=[];
        $selectAirline = AirLine::where(function ($query) use($request){
            $query->where('code','like',"%$request->term%");
                // ->OrWhere('airline_account_no','like',"%$request->term%");
        })
        ->where('status', 1);

        $selectAirline = $selectAirline->orderby('id','desc')->limit(10)->get(['id','name','code']);
        if ($selectAirline) {
            foreach ($selectAirline as $val) {
                $airline[] = array('id' => $val->id, 'label' => $val->name ."($val->code)");
            }
        }
        return $airline;
    }
    
    public function searchBaggage(Request $request){
        $baggage=[];
        $selectBaggage = Baggage::where(function ($query) use($request){
            $query->where('name','like',"%$request->term%");
                // ->OrWhere('airline_account_no','like',"%$request->term%");
        })
        ->where('status', 1);

        $selectBaggage = $selectBaggage->orderby('id','desc')->limit(10)->get(['id','name']);
        if ($selectBaggage) {
            foreach ($selectBaggage as $val) {
                $baggage[] = array('id' => $val->id, 'label' => $val->name ."($val->code)");
            }
        }
        return $baggage;
    }
}
