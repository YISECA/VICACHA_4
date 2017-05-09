<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Idrd\Usuarios\Repo\PersonaInterface;
use App\Modelos\Parques\Localidad;
use App\Modelos\Formulario\Deporte;
use App\Modelos\Formulario\Equipo;
use Illuminate\Http\Request;

class MainController extends Controller {

	protected $Usuario;
	protected $repositorio_personas;

	public function __construct(PersonaInterface $repositorio_personas)
	{
		if (isset($_SESSION['Usuario']))
			$this->Usuario = $_SESSION['Usuario'];

		$this->repositorio_personas = $repositorio_personas;
	}

  	public function buscar()
  	{
		$data = [
			'seccion' => 'Busqueda',
			'titulo' => 'Busqueda equipos',
			'status' => session('status'),
			'equipos' => Equipo::with('deporte','modalidad','categoria','localidad','upz','barrio','personas')->get()
		];

		return view('buscar', $data);
	}

    public function index(Request $request)
	{
		$fake_permissions = 'a:6:{i:0;s:5:"71766";i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";}';

		if ($request->has('vector_modulo') || $fake_permissions)
		{
			$vector = $request->has('vector_modulo') ? urldecode($request->input('vector_modulo')) : $fake_permissions;
			$user_array = unserialize($vector);
			$permissions_array = $user_array;


			$permisos = [
				'crear_equipo' => $permissions_array[1],
				'editar_equipo' => $permissions_array[1],
				'gestionar_personas' => $permissions_array[2],
			];

			$_SESSION['Usuario'] = $user_array;
			$persona = $this->repositorio_personas->obtener($_SESSION['Usuario'][0]);

			$_SESSION['Usuario']['Persona'] = $persona;
			$_SESSION['Usuario']['Permisos'] = $permisos;
			$this->Usuario = $_SESSION['Usuario']; // [0]=> string(5) "71766" [1]=> string(1) "1"
		} else {
			if(!isset($_SESSION['Usuario']))
				$_SESSION['Usuario'] = '';
		}

		if ($_SESSION['Usuario'] == '')
			return redirect()->away('http://www.idrd.gov.co/SIM/Presentacion/');

		return redirect('/buscar');

		$data = [
				'seccion' => '',
				'titulo' => 'Inicio',
		];

		//return view('master-formularios', $data);
	}

	public function logout()
	{
		$_SESSION['Usuario'] = '';
		session('Usuario', '');

		return redirect()->to('../');
	}
}
