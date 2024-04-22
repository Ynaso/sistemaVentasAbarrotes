<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comprobante extends Model
{
    use HasFactory;

    public function compras(){
        return $this->hasMany(compra::class);
    }

    public function comprobante(){
        return $this->belongsTo(comprobante::class);
    }
}
