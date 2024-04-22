<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class caracteristica extends Model
{
    use HasFactory;

    public function categoria(){
        return $this->hasOne(categoria::class);
    }
    public function marca(){
        return $this->hasOne(marca::class);
    }
    public function presentacione(){
        return $this->hasOne(presentacione::class);
    }

    protected $fillable = ['nombre', 'descripcion'];
    
}
