<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'ano',
        'paginas'
    ];

    public function getCreatedAtAttribute($valor){
        if ($valor) {
            return date('d/m/Y H:i:s', strtotime($valor));
        }
    }
}
