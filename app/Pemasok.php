<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Pemasok extends Model
{
    protected $table = 'pemasok';
    public $timestamps = false;
    protected $primaryKey  = 'id_pemasok';
}
