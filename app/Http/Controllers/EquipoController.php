<?php

namespace App\Http\Controllers;

use Redirect;
use Validator;
use Session;
use Mail;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB as DB;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Controllers\Controller;
use App\Modelos\Parques\Localidad;
use App\Modelos\Parques\Upz;
use App\Modelos\Formulario\Categoria;
use App\Modelos\Formulario\Deporte;
use App\Modelos\Formulario\Modalidad;
use App\Modelos\Formulario\Equipo;
use App\Modelos\Personas\Persona;
use App\Modelos\Personas\Documento;
use App\Modelos\Personas\Etnia;
use Idrd\Usuarios\Repo\PersonaInterface;

class EquipoController extends BaseController
{
    protected $repositorio_personas;

    public function __construct(PersonaInterface $repositorio_personas)
    {
        $this->repositorio_personas = $repositorio_personas;
    }

    public function create()
    {
        $data = [
            'seccion' => 'Formulario',
            'titulo' => 'Formulario',
            'localidades' => Localidad::all(),
            'deportes' => Deporte::all(),
            'documentos' => Documento::all(),
            'etnias' => Etnia::all(),
            'status' => session('status'),
            'formulario' => null
        ];

        return view('welcome', $data);
    }

    public function insertar(Request $request)
    {
        $validator = $this->validateForm($request);
        $modalidad_valida = $this->validateModalidad($request);   

        if ($validator->fails() || !$modalidad_valida) 
        {
            if (!$modalidad_valida) $validator->errors()->add('Limite modalidad', 'Ya se supero el limite máximo de equipos registrados para esta localidad y modalidad.');

            return redirect('/welcome')
                        ->withErrors($validator)
                        ->withInput()
                        ->with(['status' => 'error']);
        } else {
            $equipo = new Equipo([]);
            $equipo = $this->store($equipo, $request);

            return redirect('/welcome/'.$equipo['id'])
                        ->with(['status' => 'success']);
        }
    }

    public function update(Request $request, $id_equipo)
    {
        $formulario = Equipo::with('personas', 'personas.tipoDocumento')->find($id_equipo);

        $data = [
            'seccion' => 'Formulario',
            'titulo' => 'Formulario de inscripción',
            'localidades' => Localidad::all(),
            'deportes' => Deporte::all(),
            'documentos' => Documento::all(),
            'etnias' => Etnia::all(),
            'status' => session('status'),
            'formulario' => $formulario
        ];

        return view('welcome', $data);
    }

    public function editar(Request $request)
    {
        $validator = $this->validateForm($request);
        $modalidad_valida = $this->validateModalidad($request);   

        if ($validator->fails() || !$modalidad_valida) 
        {
            if (!$modalidad_valida) $validator->errors()->add('Limite modalidad', 'Ya se supero el limite de equipos registrados para esta localidad y modalidad.');

            return redirect('/welcome/'.$request->input('id'))
                        ->withErrors($validator)
                        ->withInput()
                        ->with(['status' => 'error']);
        } else {
            $equipo = Equipo::find($request->input('id'));
            $this->store($equipo, $request);

            return redirect('/welcome/'.$request->input('id'))
                        ->with(['status' => 'success']);
        }
    }

    public function procesarPersona(Request $request)
    {
        $validator = $this->validatePersona($request);

        if ($validator->fails())
            return response()->json(['estado' => false, 'errors' => $validator->errors()]);

        if ($request->input('Id_Persona') == 0)
            $persona = $this->repositorio_personas->guardar($request->input());
        else
            $persona = $this->repositorio_personas->actualizar($request->input());

        $equipos = Equipo::whereHas('personas', function($query) use ($persona)
                            {
                                return $query->where('persona.Id_Persona', $persona['Id_Persona']);
                            })->lists('id');
                            
        if(count($equipos->toArray()) > 0 && !in_array($request->input('id_equipo'), $equipos->toArray()))
           return response()->json(['estado' => 'repetido', 'errors' => 'Participante repetido']);

        // carga de archivo 1
        if ($request->hasFile('documento_de_entidad'))
        {
            if ($request->file('documento_de_entidad')->isValid())
            {
                $destinationPath = 'public/Uploads';
                $extension = $request->file('documento_de_entidad')->getClientOriginalExtension();
                $fileName = date('yy-mm-dd').rand(11111,99999).'.'.$extension;
                $request->file('documento_de_entidad')->move($destinationPath, $fileName);
                $url_documento_de_entidad = $fileName;
            }
        } else {
            $url_documento_de_entidad = '';
        }

        // carga de archivo 2
        if ($request->hasFile('afiliacion_eps'))
        {
            if ($request->file('afiliacion_eps')->isValid())
            {
                $destinationPath = 'public/Uploads';
                $extension = $request->file('afiliacion_eps')->getClientOriginalExtension();
                $fileName = date('yy-mm-dd').rand(11111,99999).'.'.$extension;
                $request->file('afiliacion_eps')->move($destinationPath, $fileName);
                $url_afiliacion_eps = $fileName;
            }
        } else {
            $url_afiliacion_eps = '';
        }

        // obtener las personas actuales para sincronizarlas
        $equipo = Equipo::with('personas')->find($request->input('id_equipo'));
        $to_sync = [];

        foreach ($equipo->personas as &$miembro)
        {
            if($miembro->Id_Persona != $persona->Id_Persona)
            {
                $to_sync[$miembro->Id_Persona] = [
                    'email' => $miembro->pivot['email'],
                    'telefono' => $miembro->pivot['telefono'],
                    'rh' => $miembro->pivot['rh'],
                    'digital_documento' => $miembro->pivot['digital_documento'],
                    'digital_eps' => $miembro->pivot['digital_eps']
                ];
            }
        }

        $to_sync[$persona->Id_Persona] = [
            'email' => $request->input('email'),
            'telefono' => $request->input('telefono'),
            'rh' => $request->input('rh'),
            'digital_documento' => $url_documento_de_entidad == '' ? $persona->pivot['digital_documento'] : $url_documento_de_entidad,
            'digital_eps' => $url_afiliacion_eps == '' ? $persona->pivot['digital_eps'] : $url_afiliacion_eps
        ];

        $equipo->personas()->sync($to_sync);

        $equipo = Equipo::with('personas')->find($request->input('id_equipo'));
        return response()->json(['estado' => true, 'persona' => $equipo->personas]);
    }

    public function borrarPersona(Request $request)
    {
        $equipo = Equipo::with('personas')->find($request->input('id_equipo'));
        $to_sync = [];

        foreach ($equipo->personas as $miembro)
        {
            if($miembro->Id_Persona != $request->input('Id_Persona'))
            {
                $to_sync[$miembro->Id_Persona] = [
                    'telefono' => $miembro->pivot['telefono'],
                    'email' => $miembro->pivot['email'],
                    'rh' => $miembro->pivot['rh'],
                    'digital_documento' => $miembro->pivot['digital_documento'],
                    'digital_eps' => $miembro->pivot['digital_eps']
                ];
            }
        }

        $equipo->personas()->sync($to_sync);

        return response()->json(['estado' => true]);
    }

    public function borrarEquipo(Request $request)
    {
        $equipo = Equipo::with('personas')->find($request->input('id_equipo'));
        $equipo->personas()->detach();
        $equipo->delete();

        return redirect('/buscar')
                    ->with(['status' => 'success']);
    }

   	public function listar_categorias(Request $request)
   	{
   	  	$modalidad = Modalidad::with('categorias')->find($request->input('id_modalidad'));
		return response()->json($modalidad->categorias);
   	}

    public function listar_deportes(Request $request)
    {
        $deportes = Deporte::get();
        return response()->json($deportes);
    }

   	public function listar_modalidad(Request $request)
   	{
        $deporte = Deporte::with('modalidad')->find($request->input('id_deporte'));
        return response()->json($deporte->modalidad);
   	}

   	public function listar_localidad()
    {
	  	$lodalidades = Localidad::get();
   	  	return response()->json($lodalidades);
   	}

    public function listar_upz(Request $request)
    {
        $localidad = Localidad::with('upz')->find($request->input('id_localidad'));
        return response()->json($localidad->upz);
    }

   	public function listar_barrios(Request $request)
    {
   	  	$upz = Upz::with('barrios')->find($request->input('id_upz'));
        return response()->json($upz->barrios);
   	}

    private function validateForm($request)
    {
        $validator = Validator::make($request->all(),
            [
                'nombre' => 'required',
                'genero' => 'required',
                'id_deporte' => 'required',
                'id_modalidad' => 'required',
                'id_categoria' => 'required',
                'id_localidad' => 'required',
                'id_upz' => 'required',
                'id_barrio' => 'required',
                'delegado' => 'required',
                'email' => 'required',
                'telefono' => 'required',
                'direccion' => 'required',
                'certificado' => 'required_if:certificado_old,0|mimes:jpeg,bmp,png,pdf'
            ]
        );

        return $validator;
    }

    private function validateModalidad($request)
    {
        if ($request->input('id_modalidad') != '' && $request->input('id_localidad'))
        {
            $modalidad = Modalidad::with(['localidades' => function($query) use ($request)
            {
                return $query->where('localidad.id_localidad', $request->input('id_localidad'))->first();
            }])->where('id', $request->input('id_modalidad'))->first();


            $registrados = Equipo::where('id_modalidad', $request->id_modalidad)
                                ->where('id', '<>', $request->input('id'))
                                ->count();

            //echo $registrados.' >= '.$modalidad->localidades[0]->pivot['cantidad'];
            //exit();

            if($registrados >= $modalidad->localidades[0]->pivot['cantidad'])
                return false;
        }

        return true;
    }

    private function validatePersona($request)
    {
        $validator = Validator::make($request->all(),
            [
                'Id_TipoDocumento' => 'required|min:1',
                'Cedula' => 'required|numeric',
                'Primer_Apellido' => 'required',
                'Primer_Nombre' => 'required',
                'telefono' => 'required',
                'email' => 'required',
                'Fecha_Nacimiento' => 'required|date',
                'Id_Etnia' => 'required|min:1',
                'Id_Pais' => 'required|min:1',
                'Id_Genero' => 'required|in:1,2'
            ]
        );

        return $validator;
    }

	private function store($equipo, $request)
    {
        $input = $request->input();
        $url = '';

        if ($request->hasFile('certificado'))
        {
            if ($request->file('certificado')->isValid())
            {
                $destinationPath = 'public/Uploads';
                $extension = $request->file('certificado')->getClientOriginalExtension();
                $fileName = date('yy-mm-dd').rand(11111,99999).'.'.$extension;
                $request->file('certificado')->move($destinationPath, $fileName);
                $url = $fileName;
            }
        } else {
            $url = $input['certificado_old'];
        }

		$equipo->nombre_equipo = $input['nombre'];
		$equipo->genero = $input['genero'];
		$equipo->id_deporte = $input['id_deporte'];
		$equipo->id_modalidad = $input['id_modalidad'];
		$equipo->id_categoria = $input['id_categoria'];
		$equipo->id_localidad = $input['id_localidad'];
		$equipo->id_upz = $input['id_upz'];
		$equipo->id_barrio = $input['id_barrio'];
		$equipo->delegado = $input['delegado'];
		$equipo->email = $input['email'];
		$equipo->telefono = $input['telefono'];
		$equipo->direccion = $input['direccion'];
        $equipo->pdf = $url ;
        $equipo->save();

        return $equipo;
    }
}
