<?php

namespace App\Http\Controllers;

use App\Models\Academique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class AcademiqueController extends Controller
{

    public function index()
    {
        return view('academiques.index');
    }

    	// handle fetch all eamployees ajax request
	public function fetchAll() {
		$academique = Academique::all();
		$output = '';
		if ($academique->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle" id="example">
            <thead>
              <tr>
                <th>Code</th>
                <th>Logo</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Telephone</th>
                <th>Status</th>
                <th>Responsable</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($academique as $aca) {
				$output .= '<tr>
                <td>' . $aca->code . '</td>
                <td><img src="storage/logos/' . $aca->logo . '" width="50" class="img-thumbnail rounded-circle"></td>
                <td>' . $aca->name .'</td>
                <td>' . $aca->email . '</td>
                <td>' . $aca->telephone . '</td>
                <td>' . $aca->status . '</td>
                <td>' . $aca->responsable . '</td>
                <td>
                  <a href="#" id="' . $aca->id . '" class="btn btn-outline-warning btn-sm mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-lock h4"></i> Fermer</a>
                  <a href="#" id="' . $aca->id . '" class="btn btn-outline-success btn-sm mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-lock h4"></i> Ouvrir</a>

                  <a href="#" id="' . $aca->id . '" class="btn btn-primary btn-sm mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i> Modifier</a>

                  <a href="#" id="' . $aca->id . '" class="btn btn-danger btn-sm mx-1 deleteIcon"><i class="bi-trash h4"></i>Supprimer</a>
                </td>
              </tr>';
			}
			$output .= '</tbody></table>';
			echo $output;
		} else {
			echo '<h1 class="text-center text-secondary my-5">Pas de donnee dans la DB</h1>';
		}
	}

    	// handle insert a new employee ajax request
	public function store(Request $request) {
    
    $validator = Validator::make($request->all(), [
      'name'=>'required|string',
      'code'=>'required|string',
      'email'=>'required|email|unique:academiques',
      'telephone'=>'required|unique:academiques',
      'ville'=>'required|string',
      'responsable'=>'required|string',
    ],[
      'name.required'=>"Nom de l'Academique est obligatoire",
      'code.required'=>"Code de l'Academique est obligatoire",
      'email.required'=>"Email de l'Academique est obligatoire",
      'email.unique'=>"Adresse email deja existe",
      'telephone.required'=>"Numero Telephone deja existe",
      'telephone.unique'=>"Telephone Academique deja existe",
    ]);
    if($validator->fails()){
      return response()->json([
        'status'=>400,
        'errors'=>$validator->messages(),
      ]);
    }else{
      $file = $request->file('logo');
      $fileName = time() . '.' . $file->getClientOriginalExtension();
      $file->storeAs('public/logos', $fileName);
  
      $empData = ['name' => $request->name, 'code' => $request->code, 'email' => $request->email, 'telephone' => $request->telephone, 'ville' => $request->ville, 'logo' => $fileName,'adresse' => $request->adresse,'notes' => $request->notes,'responsable' => $request->responsable,'status' => $request->status];
      Academique::create($empData);
      return response()->json([
        'status' => 200,
      ]);
    }
	}

    	// handle edit an employee ajax request
	public function edit(Request $request) {
		$id = $request->id;
		$academique = Academique::find($id);
		return response()->json($academique);
	}

    	// handle update an employee ajax request
	public function update(Request $request) {
		$fileName = '';
		$academique = Academique::find($request->academique_id);
		if ($request->hasFile('logo')) {
			$file = $request->file('logo');
			$fileName = time() . '.' . $file->getClientOriginalExtension();
			$file->storeAs('public/logos', $fileName);
			if ($academique->logo) {
				Storage::delete('public/logos/' . $academique->logo);
			}
		} else {
			$fileName = $request->logo;
		}

		$empData = ['name' => $request->name, 'code' => $request->code, 'email' => $request->email, 'telephone' => $request->telephone, 'ville' => $request->ville, 'logo' => $fileName,'adresse' => $request->adresse,'notes' => $request->notes,'responsable' => $request->responsable,'status' => $request->status];

		$academique->update($empData);
		return response()->json([
			'status' => 200,
		]);
	}

  // handle delete an employee ajax request
	public function delete(Request $request) {
		$id = $request->id;
		$aca = Academique::find($id);
		if (Storage::delete('public/logos/' . $aca->logo)) {
			Academique::destroy($id);
		}
	}
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'name'=>'required',
    //         'code'=>'required',
    //         'logo'=>'required|image|mimes:jpeg,png,jpg|max:2048',
    //         'telephone'=>'required|unique:academiques',
    //         'email'=>'required|unique:academiques'
    //     ]);

    //     if($validator->fails())
    //     {
    //         return response()->json([
    //             'status'=>400,
    //             'errors'=>$validator->messages()
    //         ]);
    //     }else{
    //         $academique = new Academique;
            // $academique->name = $request->input('name');
            // $academique->code = $request->input('code');
            // $academique->telephone = $request->input('telephone');
            // $academique->email = $request->input('email');
            // $academique->ville = $request->input('ville');
            // $academique->adresse = $request->input('adresse');
            // $academique->notes = $request->input('notes');
            // $academique->responsable = $request->input('responsable');
            // $academique->status = $request->input('status');

    //         if($request->hasFile('logo'))
    //         {
    //             $file = $request->file('logo');
    //             $extension = $file->getClientOriginalExtension();
    //             $filename = time() .'.' .$extension;
    //             $file->move('uploads/logos/',$filename);
    //             $academique->logo = $filename;
    //         }
    //         $academique->save();
    //         return response()->json([
    //             'status'=>200,
    //             'message'=>'Academique Saved successfully!'
    //         ]);
    //     }
    // }

}
