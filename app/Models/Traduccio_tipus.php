<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traduccio_tipus extends Model
{
    use HasFactory;
    protected $table = 'TRADUCCIO_TIPUS';
    protected $primaryKey = ['FK_ID_TIPUS, FK_ID_IDIOMA'];
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'FK_ID_TIPUS',
        'FK_ID_IDIOMA',
        'TRADUCCIO_TIPUS'
    ];
    public function tipus()
    {
        return $this->belongsTo('App\Models\Tipus', 'FK_ID_TIPUS', 'ID_TIPUS');
    }
    public function idioma()
    {
        return $this->belongsTo('App\Models\Idioma', 'FK_ID_IDIOMA', 'ID_IDIOMA');
    }
}
