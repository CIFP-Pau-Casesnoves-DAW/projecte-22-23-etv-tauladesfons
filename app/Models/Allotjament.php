<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allotjament extends Model
{
    use HasFactory;
    protected $table = 'ALLOTJAMENTS';
    protected $primaryKey = 'ID_ALLOTJAMENT';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'ID_ALLOTJAMENT',
        'NOM_COMERCIAL',
        'NUM_REGISTRE',
        'DESCRIPCIO',
        'LLITS',
        'PERSONES',
        'BANYS',
        'ADRECA',
        'DESTACAT',
        'VALORACIO_GLOBAL',
        'FK_ID_MUNICIPI',
        'FK_ID_TIPUS',
        'FK_ID_VACANCES',
        'FK_ID_CATEGORIA',
        'FK_ID_USUARI' ];
    public function municipi()
    {
        return $this->belongsTo('App\Models\Municipi', 'FK_ID_MUNICIPI', 'ID_MUNICIPI');
    }
    public function tipus()
    {
        return $this->belongsTo('App\Models\Tipus', 'FK_ID_TIPUS', 'ID_TIPUS');
    }
    public function vacances()
    {
        return $this->belongsTo('App\Models\Vacances', 'FK_ID_VACANCES', 'ID_VACANCES');
    }
    public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria', 'FK_ID_CATEGORIA', 'ID_CATEGORIA');
    }
    public function usuari()
    {
        return $this->belongsTo('App\Models\Usuari', 'FK_ID_USUARI', 'ID_USUARI');
    }
}
