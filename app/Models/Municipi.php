<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipi extends Model
{
    use HasFactory;
    protected $table = 'MUNICIPIS';
    protected $primaryKey = 'ID_MUNICIPI';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'ID_MUNICIPI',
        'NOM_MUNICIPI'
    ];
}
