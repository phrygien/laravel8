<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostIndex extends Model
{
    use HasFactory;

    protected $table = 'post_indices';

    protected $fillable = [
        'title','image','body'
    ];
}
