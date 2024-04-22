<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    public function documento(){
        return $this->belongsTo(Documento::class);
    }

    public function proveedore(){
        return $this->hasOne(proveedore::class);
    }

    public function cliente(){
        return $this->hasOne(cliente::class);
    }

    protected $fillable = ['razon_social', 'direccion', 'tipo_persona', 'documento_id', 'numero_documento'];

    
}
