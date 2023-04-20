<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societe extends Model
{
    use HasFactory;
    protected $guarded = [];    

    function employes()
    {
        return $this->hasMany(Employe::class);
    }

    function invits()
    {
        return $this->hasMany(Invit::class);
    }
}
