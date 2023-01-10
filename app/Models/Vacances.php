<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacances extends Model
{
    use HasFactory;
    protected $table = 'VACANCES';
    protected $primaryKey = 'ID_VACANCES';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'ID_VACANCES',
        'NOM_VACANCES'
    ];
}
