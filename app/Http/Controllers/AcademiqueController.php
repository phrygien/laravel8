<?php

namespace App\Http\Controllers;

use App\Models\Academique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AcademiqueController extends Controller
{

    public function index()
    {
        return view('academiques.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'code'=>'required',
            'logo'=>'required|image|mimes:jpeg,png,jpg|max:2048',
            'telephone'=>'required|unique:academiques',
            'email'=>'required|unique:academiques'
        ]);

        if($validator->fails())
        {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }else{
            $academique = new Academique;
            $academique->name = $request->input('name');
            $academique->code = $request->input('code');
            $academique->telephone = $request->input('telephone');
            $academique->email = $request->input('email');
            $academique->ville = $request->input('ville');
            $academique->adresse = $request->input('adresse');
            $academique->notes = $request->input('notes');
            $academique->responsable = $request->input('responsable');
            $academique->status = $request->input('status');

            if($request->hasFile('logo'))
            {
                $file = $request->file('logo');
                $extension = $file->getClientOriginalExtension();
                $filename = time() .'.' .$extension;
                $file->move('uploads/logos/',$filename);
                $academique->logo = $filename;
            }
            $academique->save();
            return response()->json([
                'status'=>200,
                'message'=>'Academique Saved successfully!'
            ]);
        }
    }
    
    public function fetchacademique()
    {
        $academique = Academique::all();
        return response()->json([
            'academique'=>$academique,
        ]);
    }
}
