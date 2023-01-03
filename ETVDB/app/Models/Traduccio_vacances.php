<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traduccio_vacances extends Model
{
    use HasFactory;
    protected $table = 'TRADUCCIO_VACANCES';
    protected $primaryKey = 'FK_ID_VACANCES, FK_ID_IDIOMA';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'FK_ID_VACANCES',
        'FK_ID_IDIOMA',
        'TRADUCCIO_VAC'
    ];
    public function vacances()
    {
        return $this->belongsTo('App\Models\Vacances', 'FK_ID_VACANCES', 'ID_VACANCES');
    }
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'FK_ID_IDIOMA', 'ID_IDIOMA');
    }
}
