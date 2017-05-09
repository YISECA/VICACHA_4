<?php

return array( 
 
  'conexion' => 'db_principal', 
   
  'prefijo_ruta' => 'personas', 
 
  'modelo_persona' => 'Idrd\Usuarios\Repo\Persona', 
  'modelo_documento' => 'Idrd\Usuarios\Repo\Documento', 
  'modelo_pais' => 'Idrd\Usuarios\Repo\Pais', 
  'modelo_ciudad' => 'Idrd\Usuarios\Repo\Ciudad', 
  'modelo_genero' => 'Idrd\Usuarios\Repo\Genero', 
  'modelo_etnia' => 'Idrd\Usuarios\Repo\Etnia', 
   
  //vistas que carga las vistas 
  'vista_lista' => 'list', 
 
  //lista 
  'lista'  => 'idrd.usuarios.lista', 
);
