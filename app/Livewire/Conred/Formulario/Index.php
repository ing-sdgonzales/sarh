<?php

namespace App\Livewire\Conred\Formulario;

use App\Livewire\Capacitaciones\Sesiones;
use App\Models\AplicacionCandidato;
use App\Models\Candidato;
use App\Models\CandidatoDatosLaboralesTemp;
use App\Models\CandidatoDatosPersonalesTemp;
use App\Models\Colegio;
use App\Models\ColegioCandidato;
use App\Models\Departamento;
use App\Models\EstadoCivil;
use App\Models\Municipio;
use App\Models\RegistroAcademico;
use App\Models\RegistroAcademicoCandidato;
use App\Models\TelefonoCandidato;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;
    #[Layout('layouts.app2')]

    /* Collecciones */
    public $estados_civiles, $colegios, $registros_academicos, $departamentos, $municipios;

    public $id_puesto, $formulario, $finalizar = false;

    /* Variables formulario de datos personales */
    public $imagen, $dpi, $nit, $igss, $nombre, $email, $fecha_nacimiento, $estado_civil,
        $direccion, $telefono, $departamento, $municipio, $captcha;

    /* Variables formulario de datos laborales */
    public $registro_academico, $titulo, $titulo_universitario, $colegio, $colegiado;

    public function render()
    {
        $this->estados_civiles = EstadoCivil::all();
        $this->colegios = Colegio::all();
        $this->registros_academicos = RegistroAcademico::all();
        $this->departamentos = Departamento::all();
        return view('livewire.conred.formulario.index');
    }


    public function getMunicipiosByDepartamento()
    {
        if (!empty($this->departamento)) {
            $departamento = Departamento::findOrFail($this->departamento);
            $this->municipios = $departamento->municipios;
        }
    }

    public function guardarDatosPersonales()
    {
        $this->dispatch('captchaCallback', ['message' => 'hola']);
    }

    public function guardarDatosLaborales()
    {
        $this->dispatch('captchaCallbackDL', ['message' => '']);
    }

    public function guardarDatosPersonalesAfterCaptcha($token)
    {
        $score = $this->verifyCaptcha($token);
        if ($score > 0.5) {
            $validated = $this->validate([
                'imagen' => 'required|image|file|mimes:jpg|max:2048',
                'dpi' => ['required', 'unique:candidatos_datos_personales_temp', 'filled', 'size:15', 'regex:/^[1-9]\d{3} [1-9][0-9]{4} ([0][1-9]|[1][0-9]|[2][0-2])([0][1-9]|[1][0-9]|[2][0-9]|[3][0-9])$/'],
                'nit' => 'required|filled|unique:candidatos_datos_personales_temp',
                'igss' => 'nullable',
                'nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'email' => 'required|filled|email:dns|unique:candidatos_datos_personales_temp',
                'fecha_nacimiento' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                'estado_civil' => 'required|integer|min:1',
                'telefono' => ['required', 'unique:candidatos_datos_personales_temp', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
                'direccion' => 'required|filled|regex:/[^0-9]/',
                'departamento' => 'required|integer|min:1',
                'municipio' => 'required|integer|min:1'
            ]);
            try {
                $imagen = $this->imagen->store('candidatos/formulario', 'public');
                CandidatoDatosPersonalesTemp::updateOrCreate(['dpi' => $validated['dpi']], [
                    'imagen' => $imagen,
                    'nit' => $validated['nit'],
                    'igss' => $validated['igss'],
                    'nombre' => $validated['nombre'],
                    'email' => $validated['email'],
                    'fecha_nacimiento' => $validated['fecha_nacimiento'],
                    'estados_civiles_id' => $validated['estado_civil'],
                    'telefono' => $validated['telefono'],
                    'direccion' => $validated['direccion'],
                    'municipios_id' => $validated['municipio']
                ]);
                session(['formulario' => 'datos-laborales']);
                $this->verifyFinish($validated['dpi']);
                session()->flash('message');
                return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
            } catch (QueryException $exception) {
                $error = $exception->errorInfo;
                session()->flash('error', implode($error));
                return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
            } catch (Exception $e) {
                $errorMessages = "Ocurrió un error: " . $e->getMessage();
                session()->flash('errorValidate', $errorMessages);
                return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
            }
        } else {
            session()->flash('error', 'Google piensa que eres un robot, por favor actualice la página e intente de nuevo');
            return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
        }
    }

    public function guardarDatosLaboralesAfterCaptcha($token)
    {
        $score = $this->verifyCaptcha($token);
        if ($score > 0.5) {
            $validated = $this->validate([
                'dpi' => ['required', 'unique:candidatos_datos_laborales_temp', 'filled', 'size:15', 'regex:/^[1-9]\d{3} [1-9][0-9]{4} ([0][1-9]|[1][0-9]|[2][0-2])([0][1-9]|[1][0-9]|[2][0-9]|[3][0-9])$/'],
                'registro_academico' => 'required|integer|min:1',
                'titulo' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'colegio' => 'nullable|integer|min:1',
                'colegiado' => 'nullable|required_with:colegio|regex:/^[1-9]\d*$/',
                'titulo_universitario' => 'required_if:registro_academico,>,5|nullable|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/'
            ]);
            try {
                CandidatoDatosLaboralesTemp::updateOrCreate(['dpi' => $validated['dpi']], [
                    'titulo' => $validated['titulo'],
                    'titulo_universitario' => $validated['titulo_universitario'],
                    'colegiado' => $validated['colegiado'],
                    'registros_academicos_id' => $validated['registro_academico'],
                    'colegios_id' => $validated['colegio']
                ]);
                $this->verifyFinish($validated['dpi']);
                session()->flash('message');
                session(['dpi' => $validated['dpi']]);
                return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
            } catch (QueryException $exception) {
                $error = $exception->errorInfo;
                session()->flash('error', implode($error));
                return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
            }
        } else {
            session()->flash('error', 'Google piensa que eres un robot, por favor actualice la página e intente de nuevo');
            return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
        }
    }

    public function completarFormulario()
    {
        try {
            $dpi = session('dpi');
            DB::transaction(function () use ($dpi) {
                $datos_personales = CandidatoDatosPersonalesTemp::where('dpi', $dpi)->first();
                $datos_laborales = CandidatoDatosLaboralesTemp::where('dpi', $dpi)->first();

                $imagen = basename($datos_personales->imagen);
                $path_actual = 'public/' . $datos_personales->imagen;
                $path_nuevo = 'candidatos/' . $imagen;
                Storage::move($path_actual, 'public/' . $path_nuevo);
                $candidato = Candidato::create([
                    'dpi' => $datos_personales->dpi,
                    'nit' => $datos_personales->nit,
                    'igss' => $datos_personales->igss,
                    'nombre' => $datos_personales->nombre,
                    'email' => $datos_personales->email,
                    'imagen' => $path_nuevo,
                    'fecha_nacimiento' => $datos_personales->fecha_nacimiento,
                    'fecha_registro' => date('Y-m-d'),
                    'direccion' => $datos_personales->direccion,
                    'estados_civiles_id' => $datos_personales->estados_civiles_id,
                    'municipios_id' => $datos_personales->municipios_id,
                    'tipos_contrataciones_id' => 1
                ]);

                TelefonoCandidato::create([
                    'candidatos_id' => $candidato->id,
                    'telefono' => $datos_personales->telefono
                ]);

                RegistroAcademicoCandidato::create([
                    'profesion' => $datos_laborales->titulo,
                    'estado' => 2,
                    'candidatos_id' => $candidato->id,
                    'registros_academicos_id' => $datos_laborales->registros_academicos_id
                ]);

                AplicacionCandidato::create([
                    'observacion' => 'El canidato se ha postulado',
                    'fecha_aplicacion' => date('Y-m-d'),
                    'candidatos_id' => $candidato->id,
                    'puestos_nominales_id' => $this->id_puesto
                ]);

                if (!empty($datos_laborales->colegios_id)) {
                    ColegioCandidato::create([
                        'colegiado' => $datos_laborales->colegiado,
                        'profesion' => $datos_laborales->titulo_universitario,
                        'candidatos_id' => $candidato->id,
                        'colegios_id' => $datos_laborales->colegios_id
                    ]);
                }

                $datos_personales->delete();
                $datos_laborales->delete();
            });
            Session::flush();
            session()->flash('message');
            return redirect()->route('postularse');
        } catch (QueryException $exception) {
            $error = $exception->errorInfo;
            session()->flash('error', implode($error));
            return redirect()->route('postularse.formulario.index', ['id_puesto' => $this->id_puesto]);
        }
    }

    /* 
        Esta función se utiliza para verificar que existe un registro en ambas entidades temporales y se habilita 
        el botón de completar el formulario(Finalizar).
    */
    public function verifyFinish($dpi)
    {
        DB::transaction(function () use ($dpi) {
            $can_dp = CandidatoDatosPersonalesTemp::where('dpi', $dpi)->first();
            $can_dl = CandidatoDatosLaboralesTemp::where('dpi', $dpi)->first();
            if ($can_dl && $can_dp) {
                $this->finalizar = true;
                session(['finalizar' => $this->finalizar]);
            }
        });
    }

    public function getDatosPersonales($dpi)
    {
        $datos_personales = CandidatoDatosPersonalesTemp::where('dpi', $dpi)->first();
        if ($datos_personales) {
            $this->dpi = $datos_personales->dpi;
            $this->nit = $datos_personales->nit;
            $this->igss = $datos_personales->igss;
            $this->nombre = $datos_personales->nombre;
            $this->email = $datos_personales->email;
            $this->fecha_nacimiento = $datos_personales->fecha_nacimiento;
            $this->estado_civil = $datos_personales->estados_civiles_id;
            $this->telefono = $datos_personales->telefono;
            $this->direccion = $datos_personales->direccion;
            $municipio = Municipio::find($datos_personales->municipios_id);
            $this->departamento = $municipio->departamentos_id;
            $this->getMunicipiosByDepartamento();
            $this->municipio = $datos_personales->municipios_id;
        }
    }

    public function getDatosLaborales($dpi)
    {
        $datos_laborales = CandidatoDatosLaboralesTemp::where('dpi', $dpi)->first();
        if ($datos_laborales) {
            $this->registro_academico = $datos_laborales->registros_academicos_id;
            $this->titulo = $datos_laborales->titulo;
            $this->titulo_universitario = $datos_laborales->titulo_universitario;
            $this->colegio = $datos_laborales->colegios_id;
            $this->colegiado = $datos_laborales->colegiado;
        }
    }

    public function updatedTitulo()
    {
        if ($this->registro_academico == 6) {
            $this->titulo_universitario = $this->titulo;
        } else {
            $this->reset('titulo_universitario');
        }
    }

    public function updatedRegistroAcademico()
    {
        if (!empty($this->titulo) && $this->registro_academico != 6) {
            $this->reset('titulo_universitario');
        } elseif (!empty($this->titulo) && $this->registro_academico == 6) {
            $this->titulo_universitario = $this->titulo;
        }
    }

    /*
        Esta función se utiliza para enviar el token obtenido y verficiar su puntuación. 
     */
    public function verifyCaptcha($token)
    {
        $response = Http::post('https://www.google.com/recaptcha/api/siteverify?secret=' . env('RECAPTCHAV3_SECRET') . '&response=' . $token);
        $score = $response->json()['score'];

        return $score;
    }

    public function mostrarFormulario($formulario)
    {
        $this->formulario = $formulario;
    }


    public function mount($id_puesto)
    {
        $this->id_puesto = $id_puesto;
        if (session()->has('formulario')) {
            $this->formulario = session('formulario');
        }
        if (session()->has('finalizar')) {
            $this->finalizar = session('finalizar');
        }
        if (session()->has('dpi')) {
            $dpi = session('dpi');
            $this->getDatosPersonales($dpi);
            $this->getDatosLaborales($dpi);
        }
    }
}
