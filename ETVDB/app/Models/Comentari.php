<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentari extends Model
{
    use HasFactory;
    protected $table = 'COMENTARIS';
    protected $primaryKey = 'ID_COMENTARI';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'ID_COMENTARI',
        'DESCRIPCIO',
        'HORA',
        'DATA',
        'FK_ID_USUARI',
        'FK_ID_ALLOTJAMENT'
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
