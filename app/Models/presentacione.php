<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class presentacione extends Model
{
    use HasFactory;

    public function productos(){
        return $this->belongsToMany(producto::class);
    }

    public function caracteristica(){
        return $this->belongsTo(caracteristica::class);
    }

    protected $fillable = ['caracteristica_id'];
    
}
