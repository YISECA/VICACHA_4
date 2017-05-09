<?php

namespace App;

use Idrd\Usuarios\Repo\Ciudad as MCiudad;

class Ciudad extends MCiudad
{
    //

    public function forms(){

   	return $this->hasMany('App\Form','id_ciudad');

   }
}
