<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnneeAacademique;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnneeAcademiqueController extends Controller
{
    public function index()
    {
        return view('anneeacademiques.index');
    }

        	// handle fetch all eamployees ajax request
	public function fetchAll() {
		$anneeAcademique = DB::table('annee_aacademiques')
                        ->join('academiques','academiques.id','=','annee_aacademiques.academique_id')
                        ->join('users','users.id','=','annee_aacademiques.user_add')
                        ->select('annee_aacademiques.*','users.name as user_add','academiques.name as academique','academiques.code as academique_code')
                        ->where('annee_aacademiques.academique_id',Auth::user()->academique_id)
                        ->get();

		$output = '';
		if ($anneeAcademique->count() > 0) {
			$output .= '<table class="table table-striped table-sm text-center align-middle" id="tableAnnee">
            <thead>
              <tr>
                <th>Code</th>
                <th>Date Debut</th>
                <th>Date Fin</th>
                <th>Academique Name</th>
                <th>Academique Code</th>
                <th>Ajouter Par</th>
                <th>Status</th>
                <th>Change Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';
			foreach ($anneeAcademique as $aca) {
        if($aca->status ==1){
        $status = '<span class="badge bg-success">ouvert</span>';
        $change_status = '<a href="#" id="' . $aca->id . '" class="btn btn-outline-warning btn-sm mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-lock h4"></i> Fermer</a>';
        }else{
        $change_status = '<a href="#" id="' . $aca->id . '" class="btn btn-outline-success btn-sm mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-lock h4"></i> Ouvrir</a>';
        $status = '<span class="badge bg-warning">fermé</span>';
      }
        $output .= '<tr>
                <td>' . $aca->code . '</td>
                <td>' . $aca->date_debut .'</td>
                <td>' . $aca->date_fin .'</td>
                <td>' . $aca->academique . '</td>
                <td>' . $aca->academique_code . '</td>
                <td>' . $aca->user_add . '</td>
                <td>' . $status . '</td>
                <td>' . $change_status . '</td>
                <td>
                  <a href="#" id="' . $aca->id . '" class="btn btn-dark btn-sm mx-1 editIcon" data-bs-toggle="modal" data-bs-target="#editEmployeeModal"><i class="bi-pencil-square h4"></i> Modifier</a>

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


  public function store(Request $request) {
    
    $validator = Validator::make($request->all(), [
      'code'=>'required|string',
      'date_debut'=>'required',
      'date_fin'=>'required',
    ],[
      'code.required'=>"Code de l'Annee Academique est obligatoire",
      'date_debut.required'=>"Date Debut est obligatoire",
      'date_fin.required'=>"Date Fin est obligatoire",
    ]);
    if($validator->fails()){
      return response()->json([
        'status'=>400,
        'errors'=>$validator->messages(),
      ]);
    }else{
      $empData = ['code' => $request->code, 'date_debut' => $request->date_debut, 'date_fin' => $request->date_fin, 'user_add' => Auth::user()->id, 'academique_id'=>Auth::user()->academique_id];
      AnneeAacademique::create($empData);
      return response()->json([
        'status' => 200,
      ]);
    }
	}

}
