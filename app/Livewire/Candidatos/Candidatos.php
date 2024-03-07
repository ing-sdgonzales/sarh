<?php

namespace App\Livewire\Candidatos;

use App\Models\AplicacionCandidato;
use App\Models\Candidato;
use App\Models\ColegioCandidato;
use App\Models\DependenciaNominal;
use App\Models\Entrevista;
use App\Models\EtapaAplicacion;
use App\Models\InformeEvaluacion;
use App\Models\PruebaPsicometrica;
use App\Models\PruebaTecnica;
use App\Models\RegistroAcademicoCandidato;
use App\Models\TelefonoCandidato;
use App\Notifications\AvisoRequisitos;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\WithPagination;
use Livewire\Component;

class Candidatos extends Component
{
    use WithFileUploads;
    use WithPagination;

    /* catalogos */
    public $estados_civiles, $departamentos_origen, $municipios, $registros_academicos, $colegios, $dependencias, $puestos, $tipos_contrataciones,
        $tipos_servicios;

    /* Filtro y busqueda */
    public $busqueda, $filtro;

    /* variables de consulta */
    public $id, $dpi, $nit, $igss, $nombre, $email, $imagen, $fecha_nacimiento, $fecha_registro, $fecha_ingreso,
        $direccion_domicilio, $tipo, $estado_civil, $municipio, $departamento_origen, $telefono, $registro_academico,
        $registro_academico_estado, $titulo, $colegio, $colegiado, $dependencia, $puesto, $tipo_contratacion,
        $tipo_servicio, $observacion, $fecha_aplicacion, $aprobado;

    public $entrevista, $id_puesto;
    public $control_entrevista = [['val' => 0, 'res' => 'No aprobado'], ['val' => 1, 'res' => 'Aprobado']];
    public $modal = false;
    /* Modal Expediente */
    public $modal_aprobar_expediente = false;

    /* Modal Pruebas Técnicas */
    public $modal_prueba_tecnica = false;
    public $prueba_tecnica_nombre = 'Prueba técnica', $prueba_tecnica_nota, $prueba_tecnica_fecha;

    /* Modal Pruebas Psicométricas */
    public $modal_prueba_psicometrica = false;
    public $prueba_psicometrica_nombre = 'Pruebas psicométricas', $prueba_psicometrica_fecha;

    /* Modal Informe de Evaluación */
    public $modal_informe_evaluacion = false;
    #[Validate('file|mimes:pdf|max:2048')]
    public $informe_ubicacion;

    /* Modal Fechas de Ingresos*/
    public $modal_fecha_ingreso = false;

    /* Variables organigrama */
    public $secretaria, $subsecretarias = [], $subsecretaria, $direcciones = [], $direccion, $subdirecciones = [], $subdireccion, $departamentos = [],
        $departamento, $delegaciones = [], $delegacion;

    public $showLoading = false;
    public $entrevista_modal = false;
    public $imagen_control = false, $imagen_actual;
    public $modo_edicion = false;
    public function render()
    {
        $this->estados_civiles = DB::table('estados_civiles')->select('id', 'estado_civil')->get();
        $this->departamentos_origen = DB::table('departamentos')->select('id', 'nombre')->get();
        $this->registros_academicos =  DB::table('registros_academicos')->select('id', 'nivel')->get();
        $this->colegios = DB::table('colegios')->select('id', 'nombre')->get();
        $this->dependencias = DB::table('dependencias_nominales')->select('id', 'dependencia')->whereNull('nodo_padre')->get();
        $this->tipos_contrataciones = DB::table('tipos_contrataciones')->select('id', 'tipo')->get();
        $this->tipos_servicios = DB::table('tipos_servicios')->select('id', 'tipo_servicio')->get();
        $this->fecha_registro = date('Y-m-d');
        $this->fecha_aplicacion = date('Y-m-d');
        $candidatos = DB::table('candidatos')
            ->join('aplicaciones_candidatos', 'candidatos_id', '=', 'aplicaciones_candidatos.candidatos_id')
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
            ->leftjoin('etapas_aplicaciones', 'aplicaciones_candidatos.id', '=', 'etapas_aplicaciones.aplicaciones_candidatos_id')
            ->select(
                'candidatos.id as id',
                'puestos_nominales.id as id_puesto',
                'candidatos.imagen as imagen',
                'candidatos.nombre as nombre',
                'candidatos.estado as estado',
                'renglones.renglon as renglon',
                'dependencias_nominales.dependencia as dependencia',
                'tipos_servicios.tipo_servicio as tipo_servicio',
                'registros_academicos_candidatos.profesion as profesion',
                'regiones.region as region',
                'tipos_contrataciones.tipo as tipo_contratacion',
                DB::raw('COUNT(CASE WHEN etapas_aplicaciones.fecha_fin IS NOT NULL THEN 1 END) AS conteo_etapas')
            )->groupBy('candidatos.id');
        if (!empty($this->filtro)) {
            $candidatos->where(function ($query) {
                $query->where('nombre', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('renglon', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('dependencia', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('profesion', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('region', 'LIKE', '%' . $this->filtro . '%')
                    ->orWhere('tipo_contratacion', 'LIKE', '%' . $this->filtro . '%');
            });
        }
        $candidatos = $candidatos->paginate(5);
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
                'fecha_nacimiento' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                'estado_civil' => 'required|integer|min:1',
                'fecha_registro' => 'required|date',
                'direccion_domicilio' => 'required|filled|regex:/[^0-9]/',
                'telefono' => ['required', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
                'departamento_origen' => 'required|integer|min:1',
                'municipio' => 'required|integer|min:1',
                'registro_academico' => 'required|integer|min:1',
                'titulo' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'registro_academico_estado' => 'required|integer|min:1',
                'colegio' => 'nullable|integer',
                'colegiado' => 'nullable|regex:/^[1-9]\d*$/',
                'tipo_contratacion' => 'required|integer|min:1',
                'tipo_servicio' => 'required|integer|min:1',
                'fecha_aplicacion' => 'required|date',
                'secretaria' => 'required|integer|min:1',
                'subsecretaria' => 'nullable|integer|min:1',
                'direccion' => 'nullable|integer|min:1',
                'subdireccion' => 'nullable|integer|min:1',
                'departamento' => 'nullable|integer|min:1',
                'delegacion' => 'nullable|integer|min:1',
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
                'fecha_nacimiento' => 'required|date|before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                'estado_civil' => 'required|integer|min:1',
                'fecha_registro' => 'required|date',
                'direccion_domicilio' => 'required|filled|regex:/[^0-9]/',
                'telefono' => ['required', 'regex:/^(3|4|5)\d{3}-\d{4}$/'],
                'departamento_origen' => 'required|integer|min:1',
                'municipio' => 'required|integer|min:1',
                'registro_academico' => 'required|integer|min:1',
                'titulo' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'registro_academico_estado' => 'required|integer|min:1',
                'colegio' => 'nullable|integer',
                'colegiado' => 'nullable|regex:/^[1-9]\d*$/',
                'tipo_contratacion' => 'required|integer|min:1',
                'tipo_servicio' => 'required|integer|min:1',
                'fecha_aplicacion' => 'required|date',
                'secretaria' => 'required|integer|min:1',
                'subsecretaria' => 'nullable|integer|min:1',
                'direccion' => 'nullable|integer|min:1',
                'subdireccion' => 'nullable|integer|min:1',
                'departamento' => 'nullable|integer|min:1',
                'delegacion' => 'nullable|integer|min:1',
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
                    'direccion' => $validated['direccion_domicilio'],
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
            ->leftJoin('colegios_candidatos', 'candidatos.id', '=', 'colegios_candidatos.candidatos_id')
            ->join('colegios', 'colegios_candidatos.colegios_id', '=', 'colegios.id')
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
                'registros_academicos_candidatos.registros_academicos_id as id_registro_academico',
                'registros_academicos_candidatos.profesion as profesion',
                'registros_academicos_candidatos.estado as registro_academico_estado',
                'tipos_contrataciones.id as id_tipo_contratacion',
                'tipos_servicios.id as id_tipo_servicio',
                'aplicaciones_candidatos.fecha_aplicacion as fecha_aplicacion',
                'dependencias_nominales.id as id_dependencia',
                'aplicaciones_candidatos.puestos_nominales_id as id_puesto',
                'aplicaciones_candidatos.observacion as observacion',
                'telefonos_candidatos.telefono as telefono',
                'colegios_candidatos.profesion as profesion',
                'colegios_candidatos.colegiado as colegiado',
                'colegios.id as id_colegio'
            )->where('candidatos.id', '=', $id)
            ->first();

        $this->dpi = $candidato->dpi;
        $this->nit = $candidato->nit;
        $this->igss = $candidato->igss;
        $this->nombre = $candidato->nombre;
        $this->email = $candidato->email;
        $this->imagen = $candidato->imagen;
        $this->imagen_actual = $candidato->imagen;
        $this->fecha_nacimiento = $candidato->fecha_nacimiento;
        $this->fecha_registro = $candidato->fecha_registro;
        $this->direccion_domicilio = $candidato->direccion;
        $this->estado_civil = $candidato->id_estado_civil;
        $this->departamento_origen = $candidato->id_departamento;
        $this->updatedDepartamento();
        $this->municipio = $candidato->id_municipio;
        $this->registro_academico = $candidato->id_registro_academico;
        $this->titulo = $candidato->profesion;
        $this->registro_academico_estado = $candidato->registro_academico_estado;
        $this->tipo_contratacion = $candidato->id_tipo_contratacion;
        $this->tipo_servicio = $candidato->id_tipo_servicio;
        $this->fecha_aplicacion = $candidato->fecha_aplicacion;
        $this->colegio = $candidato->id_colegio;
        $this->colegiado = $candidato->colegiado;

        $nodoHoja = DependenciaNominal::findOrFail($candidato->id_dependencia);
        $caminoCompleto = collect([$nodoHoja]);

        // Recorrer cada nodo padre hasta llegar a la raíz
        while ($nodoHoja->nodo_padre !== null) {
            // Obtener el nodo padre del nodo actual
            $nodoPadre = DependenciaNominal::findOrFail($nodoHoja->nodo_padre);

            // Agregar el nodo padre a la colección
            $caminoCompleto->prepend($nodoPadre);

            // Establecer el nodo padre como el nuevo nodo actual
            $nodoHoja = $nodoPadre;
        }

        foreach ($caminoCompleto as $nodo) {
            $nivel = $caminoCompleto->search($nodo) + 1;

            if ($nivel == 1) {
                $this->secretaria = $nodo->id;
                $this->getSubsecretariasBySecretaria();
            } elseif ($nivel == 2) {
                $this->subsecretaria = $nodo->id;
                $this->getDireccionesBySubsecretaria();
            } elseif ($nivel == 3) {
                $this->direccion = $nodo->id;
                $this->getSubdireccionesByDireccion();
            } elseif ($nivel == 4) {
                $this->subdireccion = $nodo->id;
                $this->getDepartamentosBySubdireccion();
            } elseif ($nivel == 5) {
                $this->departamento = $nodo->id;
                $this->getDelegacionesByDepartamento();
            } elseif ($nivel == 6) {
                $this->delegacion = $nodo->id;
            }
        }

        $this->telefono =  $candidato->telefono;
        $this->puesto = $candidato->id_puesto;
        $this->observacion = $candidato->observacion;

        $this->abrirModal();
    }

    public function getSubsecretariasBySecretaria()
    {
        if (!empty($this->secretaria)) {
            $this->subsecretarias = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->secretaria)->get();
            $this->getPuestosByDependencia($this->secretaria);
        } else {
            $this->subsecretarias = [];
            $this->puestos = [];
        }
        $this->subsecretaria = '';
        $this->direccion = '';
        $this->direcciones = [];
        $this->subdirecciones = [];
        $this->subdireccion = '';
        $this->departamentos = [];
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getDireccionesBySubsecretaria()
    {
        if (!empty($this->subsecretaria)) {
            $this->direcciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->subsecretaria)->get();
            $this->getPuestosByDependencia($this->subsecretaria);
        } else {
            $this->direcciones = [];
            $this->getPuestosByDependencia($this->secretaria);
        }
        $this->direccion = '';
        $this->subdirecciones = [];
        $this->subdireccion = '';
        $this->departamentos = [];
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getSubdireccionesByDireccion()
    {
        if (!empty($this->direccion)) {
            $this->subdirecciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->direccion)->get();
            $this->getPuestosByDependencia($this->direccion);
        } else {
            $this->subdirecciones = [];
            $this->getPuestosByDependencia($this->subsecretaria);
        }
        $this->subdireccion = '';
        $this->departamentos = [];
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getDepartamentosBySubdireccion()
    {
        if (!empty($this->subdireccion)) {
            $this->departamentos = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->subdireccion)->get();
            $this->getPuestosByDependencia($this->subdireccion);
        } else {
            $this->departamentos = [];
            $this->getPuestosByDependencia($this->direccion);
        }
        $this->departamento = '';
        $this->delegaciones = [];
        $this->delegacion = '';
    }

    public function getDelegacionesByDepartamento()
    {
        if (!empty($this->departamento)) {
            $this->delegaciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->departamento)->get();
            $this->getPuestosByDependencia($this->departamento);
        } else {
            $this->delegaciones = [];
            $this->getPuestosByDependencia($this->subdireccion);
        }
    }

    public function aprobarExpediente()
    {
        try {
            $aplicacion = AplicacionCandidato::select(
                'aplicaciones_candidatos.id as id_aplicacion',
                'candidatos.nombre as nombre_candidato'
            )
                ->join('candidatos', 'aplicaciones_candidatos.candidatos_id', '=', 'candidatos.id')
                ->where('candidatos_id', $this->id)
                ->where('puestos_nominales_id', $this->id_puesto)
                ->first();
            DB::transaction(function () use ($aplicacion) {
                EtapaAplicacion::where('etapas_procesos_id', 3)->where('aplicaciones_candidatos_id', $aplicacion->id_aplicacion)
                    ->update([
                        'fecha_fin' => date('Y-m-d')
                    ]);

                EtapaAplicacion::create([
                    'fecha_inicio' => date('Y-m-d'),
                    'etapas_procesos_id' => 4,
                    'aplicaciones_candidatos_id' => $aplicacion->id_aplicacion
                ]);
            });
            session()->flash('message');
            $this->cerrarExpedienteModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " recibió el expediente del candidato: " . $aplicacion->nombre_candidato);
            return redirect()->route('candidatos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarExpedienteModal();
            return redirect()->route('candidatos');
        }
    }

    public function entregaExpediente($candidato_id, $id_puesto)
    {
        $this->id = $candidato_id;
        $this->id_puesto = $id_puesto;
        $this->modal_aprobar_expediente = true;
    }

    public function cerrarExpedienteModal()
    {
        $this->modal_aprobar_expediente = false;
    }

    public function guardarFechaIngreso()
    {
        try {
            $validated = $this->validate([
                'fecha_ingreso' => 'required|date|after_or_equal:today'
            ]);
            $aplicacion = AplicacionCandidato::select(
                'aplicaciones_candidatos.id as id_aplicacion',
                'candidatos.nombre as nombre_candidato'
            )
                ->join('candidatos', 'aplicaciones_candidatos.candidatos_id', '=', 'candidatos.id')
                ->where('candidatos_id', $this->id)
                ->where('puestos_nominales_id', $this->id_puesto)
                ->first();

            DB::transaction(function () use ($validated, $aplicacion) {
                $can = Candidato::findOrFail($this->id);
                $can->fecha_ingreso = $validated['fecha_ingreso'];
                $can->save();

                EtapaAplicacion::where('etapas_procesos_id', 7)->where('aplicaciones_candidatos_id', $aplicacion->id_aplicacion)
                    ->update([
                        'fecha_fin' => date('Y-m-d')
                    ]);
            });
            session()->flash('message');
            $this->cerrarModalFechaIngreso();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " asignó la fecha de ingreso del candidato: " . $aplicacion->nombre_candidato);
            return redirect()->route('candidatos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalFechaIngreso();
            return redirect()->route('candidatos');
        }
    }

    public function fechaIngreso($id_candidato, $id_puesto)
    {
        $this->id = $id_candidato;
        $this->id_puesto = $id_puesto;
        $this->modal_fecha_ingreso = true;
    }

    public function cerrarModalFechaIngreso()
    {
        $this->fecha_ingreso = '';
        $this->modal_fecha_ingreso = false;
    }

    public function guardarInformeEvaluacion()
    {
        $ubicacion = '';
        $aplicacion = AplicacionCandidato::select(
            'aplicaciones_candidatos.id as id_aplicacion',
            'candidatos.nombre as nombre_candidato'
        )
            ->join('candidatos', 'aplicaciones_candidatos.candidatos_id', '=', 'candidatos.id')
            ->where('candidatos_id', $this->id)
            ->where('puestos_nominales_id', $this->id_puesto)
            ->first();

        $informe = InformeEvaluacion::select('id', 'fecha_carga', 'ubicacion')->where('aplicaciones_candidatos_id', $aplicacion->id_aplicacion)->first();
        if ($informe) {
            $validated = $this->validate([
                'informe_ubicacion' => 'nullable|file|mimes:pdf|max:2048'
            ]);
        } else {
            $validated = $this->validate([
                'informe_ubicacion' => 'required|file|mimes:pdf|max:2048'
            ]);
        }
        if ($validated['informe_ubicacion']) {
            if ($informe) {
                if (Storage::disk('public')->exists($informe->ubicacion)) {
                    Storage::disk('public')->delete($informe->ubicacion);
                }
            }
            $ubicacion = $this->informe_ubicacion->store('informes_evaluacion', 'public');
        } else {
            $ubicacion = $informe->ubicacion;
        }
        try {
            DB::transaction(function () use ($informe, $aplicacion, $validated, $ubicacion) {
                if ($informe) {
                    InformeEvaluacion::where('id', $informe->id)->update([
                        'fecha_carga' => now(),
                        'ubicacion' => $ubicacion
                    ]);
                } else {
                    DB::transaction(function () use ($validated, $ubicacion, $aplicacion) {
                        InformeEvaluacion::create([
                            'ubicacion' => $ubicacion,
                            'aplicaciones_candidatos_id' => $aplicacion->id_aplicacion
                        ]);

                        EtapaAplicacion::where('etapas_procesos_id', 6)->where('aplicaciones_candidatos_id', $aplicacion->id_aplicacion)
                            ->update([
                                'fecha_fin' => date('Y-m-d')
                            ]);
                        EtapaAplicacion::create([
                            'fecha_inicio' => date('Y-m-d'),
                            'etapas_procesos_id' => 7,
                            'aplicaciones_candidatos_id' => $aplicacion->id_aplicacion
                        ]);
                    });
                }
            });
            session()->flash('message');
            $this->cerrarModalInformeEvaluacion();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el informe de evaluación del candidato: " . $aplicacion->nombre_candidato);
            return redirect()->route('candidatos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalInformeEvaluacion();
            return redirect()->route('candidatos');
        }
    }

    public function informeEvaluacion($id_candidato, $id_puesto)
    {
        $this->id = $id_candidato;
        $this->id_puesto = $id_puesto;
        $this->modal_informe_evaluacion = true;
    }

    public function cerrarModalInformeEvaluacion()
    {
        $this->informe_ubicacion = '';
        $this->modal_informe_evaluacion = false;
    }

    public function guardarPruebaPsicometrica()
    {
        try {
            $validated = $this->validate([
                'prueba_psicometrica_nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'prueba_psicometrica_fecha' => 'required|date'
            ]);
            $aplicacion = AplicacionCandidato::select(
                'aplicaciones_candidatos.id as id_aplicacion',
                'candidatos.nombre as nombre_candidato'
            )
                ->join('candidatos', 'aplicaciones_candidatos.candidatos_id', '=', 'candidatos.id')
                ->where('candidatos_id', $this->id)
                ->where('puestos_nominales_id', $this->id_puesto)
                ->first();

            DB::transaction(function () use ($validated, $aplicacion) {
                $prueba = PruebaPsicometrica::select('id', 'prueba', 'fecha')->where('candidatos_id', $this->id)->first();
                if ($prueba) {
                    PruebaPsicometrica::where('id', $prueba->id)
                        ->update([
                            'prueba' => $validated['prueba_psicometrica_nombre'],
                            'fecha' => $validated['prueba_psicometrica_fecha']
                        ]);
                } else {
                    DB::transaction(function () use ($validated, $aplicacion) {
                        PruebaPsicometrica::create([
                            'prueba' => $validated['prueba_psicometrica_nombre'],
                            'fecha' => $validated['prueba_psicometrica_fecha'],
                            'candidatos_id' => $this->id
                        ]);

                        EtapaAplicacion::where('etapas_procesos_id', 5)->where('aplicaciones_candidatos_id', $aplicacion->id_aplicacion)
                            ->update([
                                'fecha_fin' => date('Y-m-d')
                            ]);

                        EtapaAplicacion::create([
                            'fecha_inicio' => date('Y-m-d'),
                            'etapas_procesos_id' => 6,
                            'aplicaciones_candidatos_id' => $aplicacion->id_aplicacion
                        ]);
                    });
                }
            });
            session()->flash('message');
            $this->cerrarModalPruebaPsicometrica();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó la prueba psicométrica del candidato: " . $aplicacion->nombre_candidato);
            return redirect()->route('candidatos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalPruebaPsicometrica();
            return redirect()->route('candidatos');
        }
    }

    public function pruebasPsicometricas($id_candidato, $id_puesto)
    {
        $this->id = $id_candidato;
        $this->id_puesto = $id_puesto;
        $prueba = PruebaPsicometrica::select('id', 'prueba', 'fecha')->where('candidatos_id', $id_candidato)->first();
        if ($prueba) {
            $this->prueba_psicometrica_nombre = $prueba->prueba;
            $this->prueba_psicometrica_fecha = $prueba->fecha;
        } else {
            $this->prueba_psicometrica_nombre = 'Pruebas psicométricas';
            $this->prueba_psicometrica_fecha = date('Y-m-d');
        }
        $this->modal_prueba_psicometrica = true;
    }

    public function cerrarModalPruebaPsicometrica()
    {
        $this->modal_prueba_psicometrica = false;
        $this->prueba_psicometrica_nombre = '';
        $this->prueba_psicometrica_fecha = '';
    }

    public function pruebasTecnicas($id_candidato, $id_puesto)
    {
        $this->id = $id_candidato;
        $this->id_puesto = $id_puesto;
        $prueba = PruebaTecnica::select('id', 'prueba', 'nota', 'fecha')->where('candidatos_id', $id_candidato)->first();
        if ($prueba) {
            $this->prueba_tecnica_nombre = $prueba->prueba;
            $this->prueba_tecnica_nota = $prueba->nota;
            $this->prueba_tecnica_fecha = $prueba->fecha;
        } else {
            $this->prueba_tecnica_nombre = 'Prueba técnica';
            $this->prueba_tecnica_fecha = date('Y-m-d');
        }
        $this->modal_prueba_tecnica = true;
    }

    public function guardarPrubaTecnica()
    {
        try {
            $validated = $this->validate([
                'prueba_tecnica_nombre' => 'required|filled|regex:/^[A-Za-záàéèíìóòúùÁÀÉÈÍÌÓÒÚÙüÜñÑ\s]+$/',
                'prueba_tecnica_nota' => 'required|integer|min:0|max:100',
                'prueba_tecnica_fecha' => 'required|date'
            ]);
            $aplicacion = AplicacionCandidato::select(
                'aplicaciones_candidatos.id as id_aplicacion',
                'candidatos.nombre as nombre_candidato'
            )
                ->join('candidatos', 'aplicaciones_candidatos.candidatos_id', '=', 'candidatos.id')
                ->where('candidatos_id', $this->id)
                ->where('puestos_nominales_id', $this->id_puesto)
                ->first();

            DB::transaction(function () use ($validated, $aplicacion) {
                $prueba = PruebaTecnica::select('id', 'prueba', 'nota', 'fecha')->where('candidatos_id', $this->id)->first();
                if ($prueba) {
                    PruebaTecnica::where('id', $prueba->id)
                        ->update([
                            'prueba' => $validated['prueba_tecnica_nombre'],
                            'nota' => $validated['prueba_tecnica_nota'],
                            'fecha' => $validated['prueba_tecnica_fecha']
                        ]);
                } else {
                    DB::transaction(function () use ($validated, $aplicacion) {
                        PruebaTecnica::create([
                            'prueba' => $validated['prueba_tecnica_nombre'],
                            'nota' => $validated['prueba_tecnica_nota'],
                            'fecha' => $validated['prueba_tecnica_fecha'],
                            'candidatos_id' => $this->id
                        ]);

                        EtapaAplicacion::where('etapas_procesos_id', 4)->where('aplicaciones_candidatos_id', $aplicacion->id_aplicacion)
                            ->update([
                                'fecha_fin' => date('Y-m-d')
                            ]);

                        EtapaAplicacion::create([
                            'fecha_inicio' => date('Y-m-d'),
                            'etapas_procesos_id' => 5,
                            'aplicaciones_candidatos_id' => $aplicacion->id_aplicacion
                        ]);
                    });
                }
            });
            session()->flash('message');
            $this->cerrarModalPruebaTecnica();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó la prueba técnica del candidato: " . $aplicacion->nombre_candidato);
            return redirect()->route('candidatos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModalPruebaTecnica();
            return redirect()->route('candidatos');
        }
    }

    public function cerrarModalPruebaTecnica()
    {
        $this->modal_prueba_tecnica = false;
        $this->prueba_tecnica_nombre = '';
        $this->prueba_tecnica_nota = '';
        $this->prueba_tecnica_fecha = '';
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

        $ca = Candidato::findOrFail($this->id);

        session()->flash('message');
        $this->cerrarEntrevistaModal();
        $this->limpiarEntrevistaModal();
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name . " guardó la entrevista con el candidato: " . $ca->nombre);
        session()->flash('message');
        $this->cerrarEntrevistaModal();
        return redirect()->route('candidatos');
    }

    public function getPuestosByDependencia($id_dependencia)
    {
        $this->puesto = '';
        if ($id_dependencia) {
            $this->puestos = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', '=', $id_dependencia)
                ->where('puestos_nominales.activo', '=', 1)
                ->where('puestos_nominales.eliminado', '=', 0)
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
        $id_dependencia = '';
        if ($this->tipo_servicio) {
            if (!empty($this->delegacion)) {
                $id_dependencia = $this->delegacion;
            } elseif (!empty($this->departamento)) {
                $id_dependencia = $this->departamento;
            } elseif (!empty($this->subdireccion)) {
                $id_dependencia = $this->subdireccion;
            } elseif (!empty($this->direccion)) {
                $id_dependencia = $this->direccion;
            } elseif (!empty($this->subsecretaria)) {
                $id_dependencia = $this->subsecretaria;
            } else {
                $id_dependencia = $this->secretaria;
            }
            $this->puestos = DB::table('puestos_nominales')
                ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
                ->select(
                    'puestos_nominales.id as id',
                    'puestos_nominales.codigo as codigo',
                    'catalogo_puestos.puesto as puesto'
                )
                ->where('puestos_nominales.dependencias_nominales_id', $id_dependencia)
                ->where('puestos_nominales.activo', '=', 1)
                ->where('puestos_nominales.eliminado', '=', 0)
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
        if ($this->departamento_origen) {
            $this->municipios = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento_origen)
                ->get();
        } else {
            $this->municipios = [];
        }
    }

    public function updatedDepartamento()
    {
        $this->getMunicipiosByDepartamento();
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

    public function updatedBusqueda()
    {
        $this->filtro = $this->busqueda;
    }

    public function cerrarModal()
    {
        $this->id = '';
        $this->dpi = '';
        $this->nit = '';
        $this->igss = '';
        $this->nombre = '';
        $this->email = '';
        $this->imagen = '';
        $this->fecha_nacimiento = '';
        $this->fecha_registro = '';
        $this->fecha_ingreso = '';
        $this->direccion_domicilio = '';
        $this->tipo = '';
        $this->estado_civil = '';
        $this->municipio = '';
        $this->departamento_origen = '';
        $this->telefono = '';
        $this->registro_academico = '';
        $this->registro_academico_estado = '';
        $this->titulo = '';
        $this->colegio = '';
        $this->colegiado = '';
        $this->dependencia = '';
        $this->puesto = '';
        $this->tipo_contratacion = '';
        $this->tipo_servicio = '';
        $this->observacion = '';
        $this->fecha_aplicacion = '';
        $this->aprobado = '';
        $this->secretaria = '';
        $this->subsecretaria = '';
        $this->subsecretarias = [];
        $this->direccion = '';
        $this->direcciones = [];
        $this->subdireccion = '';
        $this->subdirecciones = [];
        $this->departamento = '';
        $this->departamentos = [];
        $this->delegacion = '';
        $this->delegaciones = [];
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
