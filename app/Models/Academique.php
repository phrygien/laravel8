<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academique extends Model
{
    use HasFactory;

    protected $table ="academiques";

    protected $fillable = [
        'name',
        'code',
        'telephone',
        'email',
        'logo',
        'responsable',
        'notes',
        'status',
        'ville',
        'adresse'
    ];
}
