<?php

namespace App\Http\Controllers;

use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class CycleController extends Controller
{
    public function index(){
        return view('cycles.index');
    }

    public function addCycle(Request $request){
        $validator = \Validator::make($request->all(),[
            'name'=>'required|string',
            'code'=>'required',
        ]);

        if(!$validator->passes()){
             return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $cycle = new Cycle();
            $cycle->name = $request->name;
            $cycle->code = $request->code;
            $cycle->academique_id = Auth::user()->academique_id;
            $cycle->annee_academique_id = Auth::user()->anneeacademique_id;
            $query = $cycle->save();

            if(!$query){
                return response()->json(['code'=>0,'msg'=>'Something went wrong']);
            }else{
                return response()->json(['code'=>1,'msg'=>'New Cycle has been successfully saved']);
            }
        }
   }

    public function getCycleList(Request $request){
        $cycles = Cycle::all();
        return DataTables::of($cycles)
                            ->addIndexColumn()
                            ->addColumn('actions', function($row){
                                return '<div class="btn">
                                                <button class="btn btn-sm btn-primary" data-id="'.$row['id'].'" id="editCountryBtn">Modifier</button>
                                                <button class="btn btn-sm btn-danger" data-id="'.$row['id'].'" id="deleteCountryBtn">Supprimer</button>
                                        </div>';
                            })
                            ->addColumn('checkbox', function($row){
                                return '<input type="checkbox" name="country_checkbox" data-id="'.$row['id'].'"><label></label>';
                            })
                        
                            ->rawColumns(['actions','checkbox'])
                            ->make(true);
    }

    public function getCycleDetails(Request $request){
        $cycle_id = $request->cycle_id;
        $cycleDetails = Cycle::find($cycle_id);
        return response()->json(['details'=>$cycleDetails]);
    }

    public function updateCycleDetails(Request $request){
        $country_id = $request->cid;

        $validator = \Validator::make($request->all(),[
            'country_name'=>'required|unique:countries,country_name,'.$country_id,
            'capital_city'=>'required'
        ]);

        if(!$validator->passes()){
                return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
                
            $country = Country::find($country_id);
            $country->country_name = $request->country_name;
            $country->capital_city = $request->capital_city;
            $query = $country->save();

            if($query){
                return response()->json(['code'=>1, 'msg'=>'Country Details have Been updated']);
            }else{
                return response()->json(['code'=>0, 'msg'=>'Something went wrong']);
            }
        }
    }

    public function deleteSelectedCycles(Request $request){
        $cycle_ids = $request->cycles_id;
        Cycle::whereIn('id', $cycle_ids)->delete();
        return response()->json(['code'=>1, 'msg'=>'Cycle have been deleted from database']); 
     }

}
