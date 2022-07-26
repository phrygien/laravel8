<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeAacademique extends Model
{
    use HasFactory;

    protected $table = "annee_aacademiques";

    protected $fillable = [
        'code',
        'date_debut',
        'date_fin',
        'user_add',
        'academique_id'
    ];
}
