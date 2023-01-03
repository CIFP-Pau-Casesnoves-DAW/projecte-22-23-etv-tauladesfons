<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipus extends Model
{
    use HasFactory;
    protected $table = 'TIPUS';
    protected $primaryKey = 'ID_TIPUS';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'ID_TIPUS',
        'NOM_TIPUS',
    ];
}
