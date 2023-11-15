<?php

namespace App\Livewire\Candidatos;

use App\Models\AplicacionCandidato;
use App\Models\Candidato;
use App\Models\ColegioCandidato;
use App\Models\Entrevista;
use App\Models\EtapaAplicacion;
use App\Models\RegistroAcademicoCandidato;
use App\Models\TelefonoCandidato;
use App\Notifications\AvisoRequisitos;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Component;


class Candidatos extends Component
{
    use WithFileUploads;
    use WithPagination;

    /* catalogos */
    public $estados_civiles, $departamentos, $municipios, $registros_academicos, $colegios, $dependencias, $puestos, $tipos_contrataciones,
        $tipos_servicios;

    /* variables de consulta */
    public $id, $dpi, $nit, $igss, $nombre, $email, $imagen, $fecha_nacimiento, $fecha_registro,
        $direccion, $tipo, $estado_civil, $municipio, $departamento, $telefono, $registro_academico,
        $registro_academico_estado, $titulo, $colegio, $colegiado, $dependencia, $puesto, $tipo_contratacion,
        $tipo_servicio, $observacion, $fecha_aplicacion, $aprobado;

    public $entrevista;
    public $control_entrevista = [['val' => 0, 'res' => 'No aprobado'], ['val' => 1, 'res' => 'Aprobado']];
    public $modal = false;
    public $showLoading = false;
    public $entrevista_modal = false;
    public $imagen_control = false, $imagen_actual;
    public $modo_edicion = false;
    public function render()
    {
        $this->estados_civiles = DB::table('estados_civiles')->select('id', 'estado_civil')->get();
        $this->departamentos = DB::table('departamentos')->select('id', 'nombre')->get();
        $this->registros_academicos =  DB::table('registros_academicos')->select('id', 'nivel')->get();
        $this->colegios = DB::table('colegios')->select('id', 'nombre')->get();
        $this->dependencias = DB::table('dependencias_nominales')->select('id', 'dependencia')->get();
        $this->tipos_contrataciones = DB::table('tipos_contrataciones')->select('id', 'tipo')->get();
        $this->tipos_servicios = DB::table('tipos_servicios')->select('id', 'tipo_servicio')->get();
        $this->fecha_registro =  date('Y-m-d');
        $this->fecha_aplicacion = date('Y-m-d');
        $candidatos = DB::table('candidatos')
            ->join('aplicaciones_candidatos', 'candidatos.id', '=', 'aplicaciones_candidatos.candidatos_id')
            ->join('puestos_nominales', 'aplicaciones_candidatos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->join('tipos_servicios', 'puestos_nominales.tipos_servicios_id', '=', 'tipos_servicios.id')
            ->join('dependencias_nominales', 'puestos_nominales.dependencias_nominales_id', '=', 'dependencias_nominales.id')
            ->join('municipios', 'puestos_nominales.municipios_id', '=', 'municipios.id')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('regiones', 'departamentos.regiones_id', '=', 'regiones.id')
            ->join('registros_academicos_candidatos', 'candidatos.id', '=', 'registros_academicos_candidatos.candidatos_id')
            ->join('tipos_contrataciones', 'candidatos.tipos_contrataciones_id', '=', 'tipos_contrataciones.id')
            ->join('telefonos_candidatos', 'candidatos.id', '=', 'telefonos_candidatos.candidatos_id')
            ->select(
                'candidatos.id as id',
                'candidatos.imagen as imagen',
                'candidatos.nombre as nombre',
                'candidatos.estado as estado',
                'renglones.renglon as renglon',
                'dependencias_nominales.dependencia as dependencia',
                'tipos_servicios.tipo_servicio as tipo_servicio',
                'registros_academicos_candidatos.profesion as profesion',
                'regiones.region as region',
                'tipos_contrataciones.tipo as tipo_contratacion'
            );

        $candidatos = $candidatos->paginate(10);
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.candidatos.candidatos', [
            'candidatos' => $candidatos
        ]);
    }

    public function guardar()
    {
        if ($this->modo_edicion == true) {
            $validated = $this->validate([
                'dpi' => ['required', 'filled', 'size:15', 'regex:/^[1-9]\d{3} [1-9][0-9]{4} ([0][1-9]|[1][0-9]|[2][0-2])([0][1-9]|[1][0-9]|[2][0-9]|[3][0-9])$/'],
                'nit' => 'required|filled',
                'igss' => 'nullable',
                'nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'email' => 'required|filled|email:dns',
                'fecha_nacimiento' => 'required|date',
                'estado_civil' => 'required|integer|min:1',
                'fecha_registro' => 'required|date',
                'direccion' => 'required|filled|regex:/[^0-9]/',
                'telefono' => ['required', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
                'departamento' => 'required|integer|min:1',
                'municipio' => 'required|integer|min:1',
                'registro_academico' => 'required|integer|min:1',
                'titulo' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'registro_academico_estado' => 'required|integer|min:1',
                'colegio' => 'nullable|integer',
                'colegiado' => 'nullable|regex:/^[1-9]\d*$/',
                'tipo_contratacion' => 'required|integer|min:1',
                'tipo_servicio' => 'required|integer|min:1',
                'fecha_aplicacion' => 'required|date',
                'dependencia' => 'required|integer|min:1',
                'puesto' => 'required|integer|min:1',
                'observacion' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.:;¡¿,!?]+$/u'
            ]);
        } else {
            $validated = $this->validate([
                'imagen' => 'required|image|file|max:2048',
                'dpi' => ['required', 'filled', 'size:15', 'regex:/^[1-9]\d{3} [1-9][0-9]{4} ([0][1-9]|[1][0-9]|[2][0-2])([0][1-9]|[1][0-9]|[2][0-9]|[3][0-9])$/'],
                'nit' => 'required|filled',
                'igss' => 'nullable',
                'nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'email' => 'required|filled|email:dns',
                'fecha_nacimiento' => 'required|date',
                'estado_civil' => 'required|integer|min:1',
                'fecha_registro' => 'required|date',
                'direccion' => 'required|filled|regex:/[^0-9]/',
                'telefono' => ['required', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
                'departamento' => 'required|integer|min:1',
                'municipio' => 'required|integer|min:1',
                'registro_academico' => 'required|integer|min:1',
                'titulo' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'registro_academico_estado' => 'required|integer|min:1',
                'colegio' => 'nullable|integer',
                'colegiado' => 'nullable|regex:/^[1-9]\d*$/',
                'tipo_contratacion' => 'required|integer|min:1',
                'tipo_servicio' => 'required|integer|min:1',
                'fecha_aplicacion' => 'required|date',
                'dependencia' => 'required|integer|min:1',
                'puesto' => 'required|integer|min:1',
                'observacion' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s.:;¡¿,!?]+$/u'
            ]);
        }

        try {
            DB::transaction(function () use ($validated) {
                $profesion = '';
                $img = '';

                if ($this->imagen == $this->imagen_actual) {
                    $img = $this->imagen;
                } else {
                    $img = $this->imagen->store('candidatos', 'public');
                    Storage::delete('public/' . $this->imagen_actual);
                }

                /* if ($this->imagen !== null) {
                    $img = $this->imagen->store('candidatos', 'public');
                } else {
                    $img = $this->imagen;
                } */
                $candidato_new = Candidato::updateOrCreate(['id' => $this->id], [
                    'dpi' => $validated['dpi'],
                    'nit' => $validated['nit'],
                    'igss' => $validated['igss'],
                    'nombre' => $validated['nombre'],
                    'email' => $validated['email'],
                    'imagen' => $img,
                    'fecha_nacimiento' => $validated['fecha_nacimiento'],
                    'fecha_registro' => $validated['fecha_registro'],
                    'direccion' => $validated['direccion'],
                    'estados_civiles_id' => $validated['estado_civil'],
                    'municipios_id' => $validated['municipio'],
                    'tipos_contrataciones_id' => $validated['tipo_contratacion']
                ]);

                TelefonoCandidato::updateOrCreate(['candidatos_id' => $this->id], [
                    'candidatos_id' => $candidato_new->id,
                    'telefono' => $validated['telefono']
                ]);

                RegistroAcademicoCandidato::updateOrCreate(['candidatos_id' => $this->id], [
                    'profesion' => $validated['titulo'],
                    'estado' => $validated['registro_academico_estado'],
                    'candidatos_id' => $candidato_new->id,
                    'registros_academicos_id' => $validated['registro_academico']
                ]);

                AplicacionCandidato::updateOrCreate(['candidatos_id' => $this->id], [
                    'observacion' => $validated['observacion'],
                    'fecha_aplicacion' => $validated['fecha_aplicacion'],
                    'candidatos_id' => $candidato_new->id,
                    'puestos_nominales_id' => $validated['puesto']
                ]);

                if ($this->colegio != '') {
                    $profesion = $validated['titulo'];
                    ColegioCandidato::updateOrCreate(['candidatos_id' => $this->id], [
                        'colegiado' => $validated['colegiado'],
                        'profesion' => $profesion,
                        'candidatos_id' => $candidato_new->id,
                        'colegios_id' => $validated['colegio']
                    ]);
                } else {
                    $profesion = '';
                }
            });

            session()->flash('message');
            $this->cerrarModal();
            $this->modo_edicion = false;
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el candidato: " . $this->nombre);
            return redirect()->route('candidatos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            $this->modo_edicion = false;
            return redirect()->route('candidatos');
        }
    }

    public function editar($id)
    {
        $this->id = $id;
        $this->modo_edicion = true;
        $this->imagen_control = true;
        $candidato =  DB::table('candidatos')
            ->join('aplicaciones_candidatos', 'candidatos.id', '=', 'aplicaciones_candidatos.candidatos_id')
            ->join('puestos_nominales', 'aplicaciones_candidatos.puestos_nominales_id', '=', 'puestos_nominales.id')
            ->join('tipos_servicios', 'puestos_nominales.tipos_servicios_id', '=', 'tipos_servicios.id')
            ->join('dependencias_nominales', 'puestos_nominales.dependencias_nominales_id', '=', 'dependencias_nominales.id')
            ->join('municipios', 'puestos_nominales.municipios_id', '=', 'municipios.id')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('registros_academicos_candidatos', 'candidatos.id', '=', 'registros_academicos_candidatos.candidatos_id')
            ->join('tipos_contrataciones', 'candidatos.tipos_contrataciones_id', '=', 'tipos_contrataciones.id')
            ->join('telefonos_candidatos', 'candidatos.id', '=', 'telefonos_candidatos.candidatos_id')
            ->select(
                'candidatos.dpi as dpi',
                'candidatos.nit as nit',
                'candidatos.igss as igss',
                'candidatos.nombre as nombre',
                'candidatos.email as email',
                'candidatos.imagen as imagen',
                'candidatos.fecha_nacimiento as fecha_nacimiento',
                'candidatos.fecha_registro as fecha_registro',
                'candidatos.direccion as direccion',
                'candidatos.estado as estado',
                'candidatos.estados_civiles_id as id_estado_civil',
                'municipios.id as id_municipio',
                'departamentos.id as id_departamento',
                'registros_academicos_candidatos.id as id_registro_academico',
                'registros_academicos_candidatos.profesion as profesion',
                'registros_academicos_candidatos.estado as registro_academico_estado',
                'tipos_contrataciones.id as id_tipo_contratacion',
                'tipos_servicios.id as id_tipo_servicio',
                'aplicaciones_candidatos.fecha_aplicacion as fecha_aplicacion',
                'dependencias_nominales.id as id_dependencia',
                'aplicaciones_candidatos.puestos_nominales_id as id_puesto',
                'aplicaciones_candidatos.observacion as observacion',
                'telefonos_candidatos.telefono as telefono'
            )->where('candidatos.id', '=', $id)
            ->first();

        $this->dpi =  $candidato->dpi;
        $this->nit = $candidato->nit;
        $this->igss = $candidato->igss;
        $this->nombre = $candidato->nombre;
        $this->email = $candidato->email;
        $this->imagen = $candidato->imagen;
        $this->imagen_actual = $candidato->imagen;
        $this->fecha_nacimiento = $candidato->fecha_nacimiento;
        $this->fecha_registro = $candidato->fecha_registro;
        $this->direccion = $candidato->direccion;
        $this->estado_civil = $candidato->id_estado_civil;
        $this->departamento = $candidato->id_departamento;
        $this->updatedDepartamento();
        $this->municipio = $candidato->id_municipio;
        $this->registro_academico = $candidato->id_registro_academico;
        $this->titulo = $candidato->profesion;
        $this->registro_academico_estado = $candidato->registro_academico_estado;
        $this->tipo_contratacion = $candidato->id_tipo_contratacion;
        $this->tipo_servicio = $candidato->id_tipo_servicio;
        $this->fecha_aplicacion = $candidato->fecha_aplicacion;
        $this->dependencia = $candidato->id_dependencia;
        $this->updatedDependencia();
        $this->telefono =  $candidato->telefono;
        $this->puesto = $candidato->id_puesto;
        $this->observacion = $candidato->observacion;

        $this->abrirModal();
    }

    public function crearEntrevista($candidato_id)
    {
        $this->id = $candidato_id;
        $ent = DB::table('entrevistas')
            ->join('candidatos', 'entrevistas.candidatos_id', '=', 'candidatos.id')
            ->select(
                'entrevistas.observacion as observacion',
                'candidatos.aprobado as aprobado'
            )
            ->where('candidatos.id', '=', $this->id)
            ->first();

        if ($ent) {
            $this->entrevista = $ent->observacion;
            $this->aprobado = $ent->aprobado;
        } else {
            $this->entrevista = '';
        }

        $this->abrirEntrevistaModal();
    }

    public function guardarEntrevista()
    {

        DB::transaction(function () {
            Entrevista::updateOrCreate([
                'observacion' => $this->entrevista,
                'candidatos_id' => $this->id
            ]);

            if ($this->aprobado == 1) {

                $candidato = Candidato::findOrFail($this->id);
                $candidato->estado = 1;
                $candidato->aprobado = $this->aprobado;

                $candidato->save();

                $aplicacion = AplicacionCandidato::where('candidatos_id', $this->id)->first();

                EtapaAplicacion::create([
                    'aplicaciones_candidatos_id' => $aplicacion->id
                ]);

                $this->showLoading = true;
                $candidato->notify(new AvisoRequisitos);
                $this->showLoading = false;
            } elseif ($this->aprobado == 0) {
                $candidato = Candidato::findOrFail($this->id);
                $candidato->estado = 2;
                $candidato->aprobado = $this->aprobado;

                $candidato->save();
            }
        });

        session()->flash('message');
        $this->cerrarEntrevistaModal();
        $this->limpiarEntrevistaModal();
        return redirect()->route('candidatos');
    }

    public function getPuestosByDependencia()
    {
        $this->puesto = '';
        if ($this->dependencia) {
            $this->puestos = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', '=', $this->dependencia)
                ->where('puestos_nominales.estado', '=', 1)
                ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('requisitos_puestos')
                        ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
                })
                ->get();
        } else {
            $this->puestos = [];
        }
    }

    public function getPuestosByTipoServicio()
    {
        $this->puesto = '';
        $this->puestos = '';
        if ($this->tipo_servicio) {
            $this->puestos = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', '=', $this->dependencia)
                ->where('puestos_nominales.estado', '=', 1)
                ->where('puestos_nominales.tipos_servicios_id', '=', $this->tipo_servicio)
                ->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('requisitos_puestos')
                        ->whereRaw('requisitos_puestos.puestos_nominales_id = puestos_nominales.id');
                })
                ->get();
        } else {
            $this->puestos = [];
        }
    }

    public function getMunicipiosByDepartamento()
    {
        $this->municipio = '';
        if ($this->departamento) {
            $this->municipios = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento)
                ->get();
        } else {
            $this->municipios = [];
        }
    }

    public function updatedDepartamento()
    {
        $this->getMunicipiosByDepartamento();
    }

    public function updatedDependencia()
    {
        $this->getPuestosByDependencia();
    }

    public function crear()
    {
        $this->abrirModal();
    }

    public function abrirModal()
    {
        $this->modal = true;
    }

    public function abrirEntrevistaModal()
    {
        $this->entrevista_modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function cerrarEntrevistaModal()
    {
        $this->entrevista_modal = false;
        $this->limpiarEntrevistaModal();
    }

    public function limpiarEntrevistaModal()
    {
        $this->aprobado = '';
        $this->entrevista = '';
    }
}
