<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ventas extends Model
{
    use HasFactory;

    public function documento(){
        return $this->belongsTo(Documento::class);
    }

    public function user(){
        return $this->belongsTo(user::class);
    }

    public function productos(){
        return $this->belongsToMany(producto::class)->withTimestamps()->withPivot('cantidad', 'precio_venta', 'descuento');
    }
    protected $guarded = ['id'];
}
