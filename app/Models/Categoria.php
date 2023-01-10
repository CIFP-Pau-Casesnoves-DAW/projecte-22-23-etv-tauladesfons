<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $table = 'CATEGORIA';
    protected $primaryKey = 'ID_CATEGORIA';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'ID_CATEGORIA',
        'NOM_CATEGORIA',
        'TARIFA'
    ];

}
