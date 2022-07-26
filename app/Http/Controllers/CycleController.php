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
                                return '<div class="btn-group">
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

}
