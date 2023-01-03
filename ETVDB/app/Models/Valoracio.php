<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Valoracio extends Model
{
    use HasFactory;
    protected $table = 'VALORACIONS';
    protected  $primaryKey = 'ID_VALORACIO';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'ID_VALORACIO',
        'PUNTUACIO',
        'FK_ID_USUARI',
        'FK_ID_ALLOTJAMENT'
    ];
    public function usuari()
    {
        return $this->belongsTo('App\Models\Usuari', 'FK_ID_USUARI', 'ID_USUARI');
    }
    public function allotjament()
    {
        return $this->belongsTo('App\Models\Allotjament', 'FK_ID_ALLOTJAMENT', 'ID_ALLOTJAMENT');
    }
}
