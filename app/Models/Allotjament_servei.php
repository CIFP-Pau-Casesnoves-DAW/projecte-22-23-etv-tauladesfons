<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allotjament_servei extends Model
{
    use HasFactory;
    protected $table = 'ALLOTJAMENTS_SERVEIS';
    protected $primaryKey = 'FK_ID_ALLOT, FK_ID_SERVEI';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'FK_ID_ALLOT',
        'FK_ID_SERVEI'
    ];
    public function allotjament()
    {
        return $this->belongsTo('App\Models\Allotjament', 'FK_ID_ALLOT', 'ID_ALLOTJAMENT');
    }
    public function servei()
    {
        return $this->belongsTo('App\Models\Servei', 'FK_ID_SERVEI', 'ID_SERVEI');
    }
}
