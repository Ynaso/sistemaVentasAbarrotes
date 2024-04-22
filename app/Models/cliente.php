<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cliente extends Model
{
    use HasFactory;

    public function documento(){
        return $this->belongsTo(Persona::class);
    }

    public function Persona(){
        return $this->belongsTo(Persona::class);
    }

    protected $fillable = ['persona_id'];
}
