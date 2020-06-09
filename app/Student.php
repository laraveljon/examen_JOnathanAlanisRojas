<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // se obtiene los campos de la base de datos de student

    protected $fillable = [
        'nombre',
        'apellido',
        'email',
        'direccion'
    ];
}
