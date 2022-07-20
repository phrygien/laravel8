<?php

namespace App\Http\Controllers;

use App\Models\Academique;
use Illuminate\Http\Request;

class AcademiqueController extends Controller
{

    public function save(Request $request){
        $validator = \Validator::make($request->all(),[
        'name'=>'required|string',
        'code'=>'required|string|unique:academiques',
        'logo'=>'required|image',
        'telephone'=>'required|unique:academiques',
        'responsable'=>'required',
        'ville'=>'required|string'
        ],[
            'name.required'=>'Academique name is required',
            'name.string'=>'Academique name must be a string',
            'code.required'=>'Academique code is required',
            'code.string'=>'Academique code must be a string',
            'code.unique'=>'This academique code is already taken',
            'logo.required'=>'Academiqure is required',
            'logo.image'=>'Academique file must be an image',
            'telephone.required'=>'Academique telephone is required',
            'telephone.string'=>'Academique telephone must be a string',
            'telephone.unique'=>'This academique telephone is already taken',
            'responsable.required'=>'Academique responsable is required',
            'ville.required'=>'Academique ville is required',
        ]);

        if(!$validator->passes()){
            return response()->json(['code'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
            $path = 'files/';
            $file = $request->file('logo');
            $file_name = time().'_'.$file->getClientOriginalName();

        //    $upload = $file->storeAs($path, $file_name);
        $upload = $file->storeAs($path, $file_name, 'public');

            if($upload){
                Academique::insert([
                    'name'=>$request->name,
                    'code'=>$request->code,
                    'logo'=>$file_name,
                    'telephone'=>$request->telephone,
                    'email'=>$request->email,
                    'ville'=>$request->ville,
                    'adresse'=>$request->adresse,
                    'notes'=>$request->notes,
                    'responsable'=>$request->responsable,
                    'status'=>$request->status
                ]);
                return response()->json(['code'=>1,'msg'=>'New academique has been saved successfully']);
            }
        }
    }

    public function fetchAcademique()
    {
        $academiques = Academique::all();
        $data = \View::make('academiques.all_academique')->with('academiques', $academiques)->render();
        return response()->json(['code'=>1,'result'=>$data]);
    }
}
