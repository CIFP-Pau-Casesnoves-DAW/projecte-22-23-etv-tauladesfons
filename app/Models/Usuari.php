<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuari extends Model
{
    use HasFactory;
    protected $table = 'USUARIS';
    protected $primaryKey = 'ID_USUARI';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'ID_USUARI',
        'DNI',
        'NOM_COMPLET',
        'CORREU_ELECTRONIC',
        'CONTRASENYA',
        'TELEFON',
        'ADMINISTRADOR'
    ];
    protected $hidden = ['CONTRASENYA', 'TOKEN', 'ADMINISTRADOR'];
}
