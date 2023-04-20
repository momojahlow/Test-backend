<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Parental\HasParent;

class Employe extends User
{
    use HasFactory,HasParent;

    function societe()
    {
        return $this->belongsTo(Societe::class,'societe_id');
    }
}
