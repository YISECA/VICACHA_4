<?php



namespace App;



use Illuminate\Database\Eloquent\Model;



class Form extends Model

{

    //



   protected $table = 'vicacha_3';



   public function ciudad(){

	

	return $this->belongsTo('App\Ciudad','id_ciudad');



   }

    public function pais(){

	

	return $this->belongsTo('App\Pais','id_pais');



   }

    public function departamento(){

	

	return $this->belongsTo('App\Departamento','id_departamento');



   }



}



