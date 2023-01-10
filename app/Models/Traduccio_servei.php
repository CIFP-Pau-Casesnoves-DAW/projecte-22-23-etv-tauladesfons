<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traduccio_servei extends Model
{
    use HasFactory;
    protected $table = 'TRADUCCIO_SERVEIS';
    protected $primaryKey = 'FK_ID_SERVEI, FK_ID_IDIOMA';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'FK_ID_SERVEI',
        'FK_ID_IDIOMA',
        'TRADUCCIO_SERVEI'
    ];

    public function servei()
    {
        return $this->belongsTo('App\Models\Servei', 'FK_ID_SERVEI', 'ID_SERVEI');
    }

    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'FK_ID_IDIOMA', 'ID_IDIOMA');
    }
}
