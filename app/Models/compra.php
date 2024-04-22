<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compra extends Model
{
    use HasFactory;

    
    protected $fillable = ['fecha_hora', 
    'impuesto', 
    'numero_comprobante', 
    'total', 
    'comprobante_id', 
    'proveedore_id'
    ];
    
    public function Proveedore(){
        return $this->belongsTo(Proveedore::class);
    }

    public function Comprobante(){
        return $this->belongsTo(comprobante::class);
    }

    public function productos(){
        return $this->belongsToMany(producto::class)
        ->withTimestamps()
        ->withPivot('cantidad', 'precio_compra', 'precio_venta');
    }
    
}
