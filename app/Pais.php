<?php

namespace App;

use Idrd\Usuarios\Repo\Pais as MPais;

class Pais extends MPais
{
    //

   public function forms(){

   	return $this->hasMany('App\Form','id_pais');

   }
}
