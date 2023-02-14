<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $table = 'grade';
    public $timestamps = false;
    protected $primaryKey  = 'id_grade';
}
