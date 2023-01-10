<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servei extends Model
{
    use HasFactory;
    protected $table ='SERVEIS';
    protected $primaryKey = 'ID_SERVEI';
    public $timestamps = false;
    public $incrementing = false;
    public $fillable = ['ID_SERVEI','NOM_SERVEI'];


}
