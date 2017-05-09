<?php

namespace App;

use Idrd\Usuarios\Repo\Departamento as MDepartamento;

class Departamento extends MDepartamento
{
    //

    public function forms(){

   	return $this->hasMany('App\Form','id_departamento');

   }
}
