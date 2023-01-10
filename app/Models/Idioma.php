<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idioma extends Model
{
    use HasFactory;
    protected $table = 'IDIOMES';
    protected $primaryKey = 'ID_IDIOMA';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'ID_IDIOMA',
        'NOM_IDIOMA'
    ];
}
