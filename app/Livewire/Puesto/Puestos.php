<?php

namespace App\Livewire\Puesto;

use App\Models\Bonificacion;
use App\Models\BonoPuesto;
use App\Models\DependenciaNominal;
use App\Models\DependenciaSubproducto;
use App\Models\PuestoNominal;
use App\Models\Renglon;
use App\Models\RequisitoPuesto;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

use Livewire\Component;

class Puestos extends Component
{
    use WithPagination;

    /* catalogos */
    public $renglones, $regiones, $especialidades, $fuentes, $plazas, $dependencias,
        $catalogo_puestos, $departamentos_region, $municipios, $tipos_servicios, $bonos, $subproductos;

    /* variables de consulta */
    public $id, $codigo, $renglon = 1, $puesto, $partida, $region, $departamento_region, $municipio = null, $fecha_registro,
        $fuentes_financiamientos, $plaza, $especialidad, $financiado, $tipo_servicio, $bono = [],
        $salario, $subproducto, $requisito = [], $bono_calculado = 0.00, $aguinaldo = 0.00, $bono14 = 0.00;
    /* Variables organigrama */
    public $secretaria, $subsecretarias = [], $subsecretaria, $direcciones = [], $direccion, $subdirecciones = [], $subdireccion, $departamentos = [],
        $departamento, $delegaciones = [], $delegacion;

    public $modal = false;
    public $requisitos_modal = false;
    public $bonos_actuales, $puesto_requisitos, $requisitos_actuales;
    public $modo_edicion = false;
    public function render()
    {
        $this->fecha_registro = date('Y-m-d');
        $this->regiones = DB::table('regiones')->select('id', 'region', 'nombre')->get();
        $this->renglones = DB::table('renglones')->select('id', 'renglon', 'nombre')->where('tipo', '=', 0)->get();
        $this->especialidades = DB::table('especialidades')->select('id', 'codigo', 'especialidad')->get();
        $this->fuentes = DB::table('fuentes_financiamientos')->select('id', 'codigo', 'fuente')->get();
        $this->plazas = DB::table('plazas')->select('id', 'codigo', 'plaza')->get();
        $this->dependencias = DB::table('dependencias_nominales')->select('id', 'dependencia')->whereNull('nodo_padre')->get();
        $this->catalogo_puestos = DB::table('catalogo_puestos')->select('id', 'codigo', 'puesto')->get();
        $this->tipos_servicios = DB::table('tipos_servicios')->select('id', 'tipo_servicio')->get();
        $this->getPuestosByRenglon($this->renglon);

        $puestos = DB::table('puestos_nominales')
            ->join('renglones', 'puestos_nominales.renglones_id', '=', 'renglones.id')
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->join('dependencias_nominales', 'puestos_nominales.dependencias_nominales_id', '=', 'dependencias_nominales.id')
            ->select(
                'puestos_nominales.id as id',
                'puestos_nominales.codigo as codigo',
                'catalogo_puestos.puesto as puesto',
                'dependencias_nominales.dependencia as dependencia',
                'puestos_nominales.activo',
                'renglones.renglon'
            );

        $requisitos = DB::table('requisitos')->select('id', 'requisito', 'especificacion');

        $puestos = $puestos->paginate(5, pageName: 'puestos-page');
        $requisitos =  $requisitos->paginate(7, pageName: 'requisitos-page');

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.puesto.puestos', [
            'puestos' => $puestos,
            'requisitos' => $requisitos
        ]);
    }

    public function guardar()
    {
        $validated = $this->validate([
            'codigo' => 'required|min:1|regex:/^[1-9][0-9]*$/',
            'renglon' => 'required|integer|min:1',
            'puesto' => 'required|integer|min:1',
            'partida' => 'required|filled',
            'fecha_registro' => 'required|date',
            'region' => 'required|integer|min:1',
            'departamento' => 'required|integer|min:1',
            'municipio' => 'required|integer|min:1',
            'especialidad' => 'required|integer|min:1',
            'fuentes_financiamientos' => 'required|integer|min:1',
            'plaza' => 'required|integer|min:1',
            'secretaria' => 'required|integer|min:1',
            'subsecretaria' => 'nullable|integer|min:1',
            'direccion' => 'nullable|integer|min:1',
            'subdireccion' => 'nullable|integer|min:1',
            'departamento' => 'nullable|integer|min:1',
            'delegacion' => 'nullable|integer|min:1',
            'tipo_servicio' => 'required|integer|min:1',
            'financiado' => 'nullable|integer',
            'salario' => 'required|decimal:2',
            'subproducto' => 'required|integer|min:1'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $id_dependencia = '';
                if (!empty($validated['delegacion'])) {
                    $id_dependencia = $validated['delegacion'];
                } elseif (!empty($validated['departamento'])) {
                    $id_dependencia = $validated['departamento'];
                } elseif (!empty($validated['subdireccion'])) {
                    $id_dependencia = $validated['subdireccion'];
                } elseif (!empty($validated['direccion'])) {
                    $id_dependencia = $validated['direccion'];
                } elseif (!empty($validated['subsecretaria'])) {
                    $id_dependencia = $validated['subsecretaria'];
                } else {
                    $id_dependencia = $validated['secretaria'];
                }
                $puesto = PuestoNominal::updateOrCreate(['id' => $this->id], [
                    'codigo' => $validated['codigo'],
                    'partida_presupuestaria' => $validated['partida'],
                    'financiado' => $validated['financiado'],
                    'fecha_registro' => date('Y-m-d'),
                    'especialidades_id' => $validated['especialidad'],
                    'renglones_id' => $validated['renglon'],
                    'plazas_id' => $validated['plaza'],
                    'salario' => $validated['salario'],
                    'fuentes_financiamientos_id' => $validated['fuentes_financiamientos'],
                    'dependencias_nominales_id' => $id_dependencia,
                    'municipios_id' => $validated['municipio'],
                    'catalogo_puestos_id' => $validated['puesto'],
                    'tipos_servicios_id' => $validated['tipo_servicio']
                ]);

                $this->puesto = $puesto->id;

                if ($this->bonos_actuales != '') {
                    $bonos_eliminados = array_diff($this->bonos_actuales, $this->bono);
                }

                if (!empty($bonos_eliminados)) {
                    DB::table('bonos_puestos')
                        ->where('puestos_nominales_id', '=', $puesto->id)
                        ->whereIn('bonificaciones_id', $bonos_eliminados)
                        ->delete();
                }

                foreach ($this->bono as $bn) {
                    $bono = Bonificacion::findOrFail($bn);
                    if ($bono->bono == 'Bono por disponibilidad y riesgo') {
                        BonoPuesto::create([
                            'bonificaciones_id' => $bn,
                            'puestos_nominales_id' => $puesto->id,
                            'cantidad' => $this->bono_calculado
                        ]);
                    } elseif ($bono->bono == 'Aguinaldo') {
                        BonoPuesto::create([
                            'bonificaciones_id' => $bn,
                            'puestos_nominales_id' => $puesto->id,
                            'cantidad' => $this->aguinaldo
                        ]);
                    } elseif ($bono->bono == 'Bono 14') {
                        BonoPuesto::create([
                            'bonificaciones_id' => $bn,
                            'puestos_nominales_id' => $puesto->id,
                            'cantidad' => $this->bono14
                        ]);
                    } else {
                        BonoPuesto::create([
                            'bonificaciones_id' => $bn,
                            'puestos_nominales_id' => $puesto->id,
                            'cantidad' => $bono->cantidad
                        ]);
                    }
                }
            });

            $log = DB::table('catalogo_puestos')
                ->join('puestos_nominales', 'catalogo_puestos.id', '=', 'puestos_nominales.catalogo_puestos_id')
                ->select(
                    'catalogo_puestos.puesto as puesto',
                    'puestos_nominales.codigo as codigo'
                )
                ->where('puestos_nominales.id', '=', $this->puesto)
                ->first();

            session()->flash('message');
            $this->cerrarModal();
            $this->modo_edicion = false;
            $this->limpiarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó el puesto: " . $log->codigo . "-" . $log->puesto);
            return redirect()->route('puestos');
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            $this->modo_edicion = false;
            $this->limpiarModal();
            return redirect()->route('puestos');
        }
    }

    public function updatedSalario()
    {
        if ($this->renglon != '' && $this->salario != '') {
            $renglon = Renglon::findOrFail($this->renglon);
            if ($renglon->renglon = '021') {
                $bonos = DB::table('bonificaciones')
                    ->join('bonos_renglones', 'bonificaciones.id', '=', 'bonos_renglones.bonificaciones_id')
                    ->join('renglones', 'bonos_renglones.renglones_id', '=', 'renglones.id')
                    ->select(
                        'bonificaciones.bono as bono',
                        'bonificaciones.cantidad as cantidad',
                        'renglones.renglon as renglon'
                    )
                    ->where('renglones.renglon', 'like', '025')
                    ->orWhere('renglones.renglon', 'like', '026')
                    ->orWhere('renglones.renglon', 'like', '027')
                    ->get();
                foreach ($bonos as $bono) {
                    if ($bono->bono == 'Bono por disponibilidad y riesgo') {
                        $this->bono_calculado = number_format($this->salario * floatval($bono->cantidad), 2, '.', '');
                    }
                }
            }
            $this->aguinaldo = number_format($this->salario, 2, '.', '');
        } else {
            $this->bono_calculado = number_format(0.00, 2, '.', '');
        }

        if (!empty($this->bono)) {
            $this->actualizarBonos();
        }
    }

    public function editar($id)
    {
        $this->id = $id;
        $this->modo_edicion = true;
        $puesto = PuestoNominal::findOrFail($id);
        $this->codigo = $puesto->codigo;
        $this->salario = $puesto->salario;
        $this->partida = $puesto->partida_presupuestaria;
        if ($puesto->financiado == 1) {
            $this->financiado = true;
        } else {
            $this->financiado = false;
        }
        $this->fecha_registro = $puesto->fecha_registro;
        $this->especialidad = $puesto->especialidades_id;
        $this->renglon = $puesto->renglones_id;
        $this->updatedRenglon();
        $this->plaza = $puesto->plazas_id;
        $this->fuentes_financiamientos = $puesto->fuentes_financiamientos_id;

        $nodoHoja = DependenciaNominal::findOrFail($puesto->dependencias_nominales_id);
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

        $subproducto = '';

        foreach ($caminoCompleto as $nodo) {
            $nivel = $caminoCompleto->search($nodo) + 1;

            if ($nivel == 1) {
                $this->secretaria = $nodo->id;
                $this->getSubsecretariasBySecretaria();
                $subproducto = DependenciaSubproducto::select('subproductos_id')->where('dependencias_nominales_id', $this->secretaria)->first();
            } elseif ($nivel == 2) {
                $this->subsecretaria = $nodo->id;
                $this->getDireccionesBySubsecretaria();
                $subproducto = DependenciaSubproducto::select('subproductos_id')->where('dependencias_nominales_id', $this->subsecretaria)->first();
            } elseif ($nivel == 3) {
                $this->direccion = $nodo->id;
                $this->getSubdireccionesByDireccion();
                $subproducto = DependenciaSubproducto::select('subproductos_id')->where('dependencias_nominales_id', $this->direccion)->first();
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

        $this->subproducto = $subproducto->subproductos_id;

        $municipio_control = DB::table('municipios')
            ->join('departamentos', 'municipios.departamentos_id', '=', 'departamentos.id')
            ->join('regiones', 'departamentos.regiones_id', '=', 'regiones.id')
            ->select([
                'departamentos.id as id_departamento',
                'regiones.id as id_region'
            ])->where('municipios.id', '=', $puesto->municipios_id)
            ->first();

        $this->bono = DB::table('bonos_puestos')
            ->select('bonificaciones_id')
            ->where('puestos_nominales_id', '=', $id)
            ->pluck('bonificaciones_id')
            ->toArray();
        $this->bonos_actuales = $this->bono;
        $this->region = $municipio_control->id_region;
        $this->updatedRegion();
        $this->municipio = $puesto->municipios_id;
        $this->tipo_servicio = $puesto->tipos_servicios_id;
        $this->puesto = $puesto->catalogo_puestos_id;
        $this->updatedSalario();
        $this->abrirModal();
    }

    public function actualizarBonos()
    {
        if (!empty($this->salario) && !empty($this->renglon)) {
            $renglon = Renglon::findOrFail($this->renglon);
            $this->aguinaldo = number_format($this->salario, 2, '.', '');

            if ($renglon->renglon == '011') {
                $bonos = Bonificacion::select('bono', 'cantidad')->whereIn('id', $this->bono)->get();
                if (!empty($bonos)) {
                    foreach ($bonos as $bono) {
                        if ($bono->bono == 'Bono profesional') {
                            $this->aguinaldo += number_format($bono->cantidad, 2, '.', '');
                        } elseif ($bono->bono == 'Complemento personal') {
                            $this->aguinaldo += number_format($bono->cantidad, 2, '.', '');
                        } elseif ($bono->bono == 'Bono CONRED') {
                            $this->aguinaldo += number_format($bono->cantidad, 2, '.', '');
                        }
                    }
                    $this->bono14 = $this->aguinaldo;
                }
            } elseif ($renglon->renglon == '021') {
                if (!empty($this->bono)) {
                    if (in_array(4, $this->bono) && in_array(10, $this->bono)) {

                        $index = array_search(10, $this->bono);
                        if ($index !== false) {
                            unset($this->bono[$index]);
                            $this->bono = [];
                        }
                    }
                }
                if (is_array($this->bono)) {
                    $bonos = Bonificacion::select('bono', 'cantidad')->whereIn('id', $this->bono)->get();
                }
                if (!empty($bonos)) {
                    foreach ($bonos as $bono) {
                        if ($bono->bono == 'Bono profesional' || $bono->bono == 'Bono de antigüedad') {
                            $this->aguinaldo += number_format($bono->cantidad, 2, '.', '');
                        }
                    }
                    $this->bono14 = $this->aguinaldo;
                }
            } elseif ($renglon->renglon == '022') {
                $bonos = Bonificacion::select('bono', 'cantidad')->whereIn('id', $this->bono)->get();
                if (!empty($bonos)) {
                    foreach ($bonos as $bono) {
                        if ($bono->bono == 'Bono profesional') {
                            $this->aguinaldo += number_format($bono->cantidad, 2, '.', '');
                        }
                    }
                    $this->bono14 = $this->aguinaldo;
                }
            } elseif ($renglon->renglon == '031') {
                /* 
                    Para este caso en particular el Aguinaldo se calcula mediante el producto del jornal (salario base) 
                    y los días del mes de noviembre más el bono por ajuste al salario mínimo . Actualmente noviembre tien 
                    30 días, pero si surge algún cambio durante el tiempo de uso del software se debe cambiar esta constante.
                */
                $bonos = Bonificacion::select('bono', 'cantidad')->whereIn('id', $this->bono)->get();
                $dias_noviembre = 30;
                if (!empty($bonos)) {
                    foreach ($bonos as $bono) {
                        if ($bono->bono == 'Bono por ajuste al salario mínimo') {
                            $calculo_aguinaldo = round($this->salario * $dias_noviembre, 2, PHP_ROUND_HALF_UP);
                            $this->aguinaldo += number_format($calculo_aguinaldo + $bono->cantidad, 2, '.', '');
                        }
                    }
                    $this->bono14 = $this->aguinaldo;
                }
            }
        }
    }

    public function getPuestosByRenglon()
    {
        $this->catalogo_puestos = DB::table('catalogo_puestos')
            ->select('id', 'codigo', 'puesto')
            ->where('renglones_id', '=', $this->renglon)
            ->get();

        if ($this->renglon == 1) {
            $this->bonos = DB::table('bonificaciones')
                ->join('bonos_renglones', 'bonificaciones.id', '=', 'bonos_renglones.bonificaciones_id')
                ->join('renglones', 'bonos_renglones.renglones_id', '=', 'renglones.id')
                ->select(
                    'bonificaciones.id as id',
                    'bonificaciones.bono as bono',
                    'bonificaciones.cantidad as cantidad',
                    'renglones.renglon as renglon',
                    'renglones.nombre as nombre'
                )
                ->where('renglones.renglon', 'like', '012')
                ->orWhere('renglones.renglon', 'like', '014')
                ->orWhere('renglones.renglon', 'like', '015')
                ->orWhere('renglones.renglon', 'like', '063')
                ->orWhere('renglones.renglon', 'like', '071')
                ->orWhere('renglones.renglon', 'like', '072')
                ->orWhere('renglones.renglon', 'like', '073')
                ->get();
        } elseif ($this->renglon == 5) {
            $this->bonos = DB::table('bonificaciones')
                ->join('bonos_renglones', 'bonificaciones.id', '=', 'bonos_renglones.bonificaciones_id')
                ->join('renglones', 'bonos_renglones.renglones_id', '=', 'renglones.id')
                ->select(
                    'bonificaciones.id as id',
                    'bonificaciones.bono as bono',
                    'bonificaciones.cantidad as cantidad',
                    'renglones.renglon as renglon',
                    'renglones.nombre as nombre'
                )
                ->where('renglones.renglon', 'like', '025')
                ->orWhere('renglones.renglon', 'like', '026')
                ->orWhere('renglones.renglon', 'like', '027')
                ->orWhere('renglones.renglon', 'like', '071')
                ->orWhere('renglones.renglon', 'like', '072')
                ->orWhere('renglones.renglon', 'like', '073')
                ->get();
        } elseif ($this->renglon == 6) {
            $this->bonos = DB::table('bonificaciones')
                ->join('bonos_renglones', 'bonificaciones.id', '=', 'bonos_renglones.bonificaciones_id')
                ->join('renglones', 'bonos_renglones.renglones_id', '=', 'renglones.id')
                ->select(
                    'bonificaciones.id as id',
                    'bonificaciones.bono as bono',
                    'bonificaciones.cantidad as cantidad',
                    'renglones.renglon as renglon',
                    'renglones.nombre as nombre'
                )
                ->where(function ($query) {
                    $query->where('renglones.renglon', 'like', '025')
                        ->orWhere('renglones.renglon', 'like', '026')
                        ->orWhere('renglones.renglon', 'like', '027')
                        ->orWhere('renglones.renglon', 'like', '071')
                        ->orWhere('renglones.renglon', 'like', '072')
                        ->orWhere('renglones.renglon', 'like', '073');
                })
                ->where('bonificaciones.bono', 'not like', '%Bono por disponibilidad y riesgo%')
                ->where('bonificaciones.bono', 'not like', '%Bono de antigüedad%')
                ->get();
        } elseif ($this->renglon == 10) {
            $this->bonos = [];
        } elseif ($this->renglon == 11) {
            $this->bonos = DB::table('bonificaciones')
                ->join('bonos_renglones', 'bonificaciones.id', '=', 'bonos_renglones.bonificaciones_id')
                ->join('renglones', 'bonos_renglones.renglones_id', '=', 'renglones.id')
                ->select(
                    'bonificaciones.id as id',
                    'bonificaciones.bono as bono',
                    'bonificaciones.cantidad as cantidad',
                    'renglones.renglon as renglon',
                    'renglones.nombre as nombre'
                )
                ->where('renglones.renglon', 'like', '032')
                ->orWhere('renglones.renglon', 'like', '033')
                ->orWhere('renglones.renglon', 'like', '071')
                ->orWhere('renglones.renglon', 'like', '072')
                ->orWhere('renglones.renglon', 'like', '073')
                ->get();
        }
    }

    public function agregarRequisitos($id)
    {
        $this->id = $id;
        $this->puesto_requisitos = DB::table('puestos_nominales')
            ->join('catalogo_puestos', 'puestos_nominales.catalogo_puestos_id', '=', 'catalogo_puestos.id')
            ->select(
                'puestos_nominales.codigo as cod_puesto',
                'catalogo_puestos.codigo as cod_catalogo',
                'catalogo_puestos.puesto as puesto'
            )
            ->where('puestos_nominales.id', '=', $id)
            ->first();
        $this->requisito = DB::table('requisitos_puestos')
            ->select('requisitos_id')
            ->where('puestos_nominales_id', '=', $id)
            ->pluck('requisitos_id')
            ->toArray();

        $this->requisitos_actuales = $this->requisito;
        $this->abrirModalAsignar();
    }

    public function guardarRequisitos()
    {
        if ($this->requisitos_actuales != '') {
            $requisitos_eliminados = array_diff($this->requisitos_actuales, $this->requisito);
        }

        if (!empty($requisitos_eliminados)) {
            DB::table('requisitos_puestos')
                ->where('puestos_nominales_id', '=', $this->id)
                ->whereIn('requisitos_id', $requisitos_eliminados)
                ->delete();
        }

        foreach ($this->requisito as $req) {
            RequisitoPuesto::updateOrCreate([
                'requisitos_id' => $req,
                'puestos_nominales_id' => $this->id
            ]);
        }

        $log = DB::table('catalogo_puestos')
            ->join('puestos_nominales', 'catalogo_puestos.id', '=', 'puestos_nominales.catalogo_puestos_id')
            ->select(
                'puestos_nominales.codigo as codigo',
                'catalogo_puestos.puesto as puesto'
            )
            ->where('puestos_nominales.id', '=', $this->id)
            ->first();

        session()->flash('message');
        $this->cerrarModalAsignar();
        $this->limpiarModalAsignar();
        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name . " actualizó los requisitos del puesto: " . $log->codigo . "-" . $log->puesto);
        return redirect()->route('puestos');
    }

    public function getSubsecretariasBySecretaria()
    {
        if (!empty($this->secretaria)) {
            $this->subsecretarias = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->secretaria)->get();
            $this->getSubproductosByDependencia($this->secretaria);
            $this->subdireccion = '';
            $this->direccion = '';
            $this->direcciones = [];
            $this->subdirecciones = [];
            $this->subdireccion = '';
            $this->departamentos = [];
            $this->departamento = '';
            $this->delegaciones = [];
            $this->delegacion = '';
        } else {
            $this->subsecretarias = '';
        }
    }

    public function getDireccionesBySubsecretaria()
    {
        if (!empty($this->subsecretaria)) {
            $this->direcciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->subsecretaria)->get();
            $this->getSubproductosByDependencia($this->subsecretaria);
            $this->direccion = '';
            $this->subdirecciones = [];
            $this->subdireccion = '';
            $this->departamentos = [];
            $this->departamento = '';
            $this->delegaciones = [];
            $this->delegacion = '';
        } else {
            $this->direcciones = '';
        }
    }

    public function getSubdireccionesByDireccion()
    {
        if (!empty($this->direccion)) {
            $this->subdirecciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->direccion)->get();
            $this->getSubproductosByDependencia($this->direccion);
            $this->subdireccion = '';
            $this->departamentos = [];
            $this->departamento = '';
            $this->delegaciones = [];
            $this->delegacion = '';
        } else {
            $this->subdirecciones = '';
        }
    }

    public function getDepartamentosBySubdireccion()
    {
        if (!empty($this->subdireccion)) {
            $this->departamentos = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->subdireccion)->get();
            $this->departamento = '';
            $this->delegaciones = [];
            $this->delegacion = '';
        } else {
            $this->departamentos = '';
        }
    }

    public function getDelegacionesByDepartamento()
    {
        if (!empty($this->departamento)) {
            $this->delegaciones = DependenciaNominal::select('id', 'dependencia')->where('nodo_padre', $this->departamento)->get();
        } else {
            $this->delegaciones = '';
        }
    }

    public function getSubproductosByDependencia($id_dependencia)
    {
        $this->subproductos = DB::table('subproductos')
            ->join('dependencias_subproductos', 'subproductos.id', '=', 'dependencias_subproductos.subproductos_id')
            ->select(
                'subproductos.id as id',
                'subproductos.codigo as codigo',
                'subproductos.proyecto as proyecto'
            )
            ->where('dependencias_subproductos.dependencias_nominales_id', '=', $id_dependencia)
            ->get();
    }

    public function getDepartamentosByRegion()
    {
        if ($this->region) {
            $this->departamentos_region = DB::table('departamentos')
                ->select('id', 'nombre', 'regiones_id')
                ->where('regiones_id', '=', $this->region)
                ->get();
            if ($this->departamentos_region->count() > 0) {
                $this->departamento_region = $this->departamentos_region[0]->id;
            }
        } else {
            $this->departamentos_region = [];
        }
    }

    public function getMunicipiosByDepartamento()
    {
        if ($this->departamento) {
            $this->municipios = DB::table('municipios')
                ->select('id', 'nombre', 'departamentos_id')
                ->where('departamentos_id', '=', $this->departamento)
                ->get();
        } else {
            $this->municipios = [];
        }
    }

    public function updatedRegion()
    {
        $this->getDepartamentosByRegion();
        $this->getMunicipiosByDepartamento();
    }

    public function updatedRenglon()
    {
        $this->getPuestosByRenglon($this->renglon);
    }

    public function crear()
    {
        $this->abrirModal();
    }

    public function abrirModal()
    {
        $this->modal = true;
    }

    public function limpiarModal()
    {
        $this->codigo = '';
        $this->partida = '';
        $this->salario = '';
        $this->bono = [];
        $this->financiado = false;
        $this->fecha_registro = date('Y-m-d');
        $this->especialidad = '';
        $this->renglon = '';
        $this->plaza = '';
        $this->fuentes_financiamientos = '';
        $this->secretaria = '';
        $this->subsecretaria = '';
        $this->direccion = '';
        $this->subdireccion = '';
        $this->departamento = '';
        $this->delegacion = '';
        $this->region = '';
        $this->updatedRegion();
        $this->municipio = '';
        $this->tipo_servicio = '';
        $this->puesto = '';
        $this->aguinaldo = '';
        $this->bono14 = '';
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->id = '';
        $this->limpiarModal();
        $this->resetPage(pageName: 'requisitos-page');
        return redirect()->route('puestos');
    }

    public function abrirModalAsignar()
    {
        $this->requisitos_modal = true;
    }

    public function cerrarModalAsignar()
    {
        $this->requisitos_modal = false;
        $this->limpiarModalAsignar();
    }

    public function limpiarModalAsignar()
    {
        $this->requisito = [];
    }
}
