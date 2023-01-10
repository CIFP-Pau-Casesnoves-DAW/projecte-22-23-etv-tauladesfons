<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $table = 'RESERVA';
    protected $primaryKey = 'ID_RESERVA';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'ID_RESERVA',
        'FK_ID_USUARI',
        'FK_ID_ALLOTJAMENT',
        'DATA_INICIAL',
        'DATA_FINAL',
        'CONFIRMADA'
    ];
    public function allotjament()
    {
        return $this->belongsTo(Allotjament::class, 'FK_ID_ALLOTJAMENT', 'ID_ALLOTJAMENT');
    }
    public function usuari()
    {
        return $this->belongsTo(Usuari::class, 'FK_ID_USUARI', 'ID_USUARI');
    }
}
