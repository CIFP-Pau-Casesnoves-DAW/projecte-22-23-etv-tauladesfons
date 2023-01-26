<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fotografia extends Model
{
    use HasFactory;
    protected $table = 'FOTOGRAFIES';
    protected $primaryKey = 'ID_FOTO';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'ID_FOTO',
        'FOTO',
        'FK_ID_ALLOTJAMENT'
    ];
    public function allotjament()
    {
        return $this->belongsTo('App\Models\Allotjament', 'FK_ID_ALLOTJAMENT', 'ID_ALLOTJAMENT');
    }

}
