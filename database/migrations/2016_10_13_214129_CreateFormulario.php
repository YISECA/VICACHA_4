<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormulario extends Migration
{
  /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

      Schema::create('CERRO_ELEFANTE_2016_III', function($table)
      {        
        $table->increments('id');
        $table->bigInteger('cedula');
        $table->enum('tipo_documento',array('Cédula de Ciudadania', 'Cédula de Extranjeria'));    
        $table->text('primer_nombre');
        $table->text('segundo_nombre');
        $table->text('primer_apellido');
        $table->text('segundo_apellido');
        $table->enum('genero', array('Masculino', 'Femenino'));
        $table->date('fecha_nacimiento');
        $table->text('mail');
        $table->text('celular');    
        $table->text('eps');
        $table->timestamps();
      });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::drop('CERRO_ELEFANTE_2016_III');
        //
    }
}
