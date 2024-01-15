<?php

namespace App\Livewire\Clinica;

use App\Models\Empleado;
use App\Models\RegistroMedico;
use Exception;
use Livewire\Component;

class Consulta extends Component
{
    public $id_empleado, $id_registro, $empleado;

    /* Colecciones */
    public $registros_medicos;

    /*  Variables modal crear y editar consulta */
    public $modal = false;
    public $fecha_consulta, $consulta, $receta, $proxima_consulta;

    public function render()
    {
        $this->empleado = Empleado::select(
            'empleados.imagen as imagen',
            'empleados.nombres as nombres',
            'empleados.apellidos as apellidos',
            'grupos_sanguineos.grupo as grupo_sanguineo',
            'historias_clinicas.padecimiento_salud as padecimiento_salud',
            'historias_clinicas.tipo_enfermedad as tipo_enfermedad',
            'historias_clinicas.intervencion_quirurgica as intervencion_quirurgica',
            'historias_clinicas.tipo_intervencion as tipo_intervencion',
            'historias_clinicas.sufrido_accidente as sufrico_accidente',
            'historias_clinicas.tipo_accidente as tipo_accidente',
            'historias_clinicas.alergia_medicamento as alergia_medicamento',
            'historias_clinicas.tipo_medicamento as tipo_medicamento',
            'contactos_emergencias.nombre as nombre_emergencia',
            'contactos_emergencias.telefono as telefono_emergencia'
        )
            ->join('grupos_sanguineos', 'empleados.grupos_sanguineos_id', '=', 'grupos_sanguineos.id')
            ->join('historias_clinicas', 'empleados.id', '=', 'historias_clinicas.empleados_id')
            ->join('contactos_emergencias', 'empleados.id', '=', 'contactos_emergencias.empleados_id')
            ->where('empleados.id', $this->id_empleado)
            ->first();

        $this->registros_medicos = RegistroMedico::all()->where('empleados_id', $this->id_empleado);

        activity()
            ->causedBy(auth()->user())
            ->withProperties(['user_id' => auth()->id()])
            ->log("El usuario " . auth()->user()->name .  " visitó la página: " . request()->path());
        return view('livewire.clinica.consulta');
    }

    public function guardar()
    {
        try {
            $validated = $this->validate([
                'fecha_consulta' => 'required|date',
                'consulta' => 'required|filled|regex:/^[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s.:;,-]+$/u',
                'receta' => ['required', 'filled', 'regex:/^[\d]+(?:\.\d{1,2})?|[A-Za-záéíóúÁÉÍÓÚüÜñÑ\s.:;,-]+$/u'],
                'proxima_consulta' => 'nullable|date'
            ]);

            RegistroMedico::updateOrCreate(['id' => $this->id_registro], [
                'fecha_consulta' => $validated['fecha_consulta'],
                'consulta' => $validated['consulta'],
                'receta' => $validated['receta'],
                'proxima_consulta' => $validated['proxima_consulta'],
                'empleados_id' => $this->id_empleado
            ]);

            $empleado = Empleado::findOrFail($this->id_empleado);
            session()->flash('message');
            $this->cerrarModal();
            activity()
                ->causedBy(auth()->user())
                ->withProperties(['user_id' => auth()->id()])
                ->log("El usuario " . auth()->user()->name . " guardó una consulta para el empleado: " . $empleado->nombres . ' ' . $empleado->apellidos);
            return redirect()->route('consultas', ['id_empleado' => $this->id_empleado]);
        } catch (Exception $e) {
            $errorMessages = "Ocurrió un error: " . $e->getMessage();
            session()->flash('error', $errorMessages);
            $this->cerrarModal();
            return redirect()->route('consultas', ['id_empleado' => $this->id_empleado]);
        }
    }

    public function editar($id)
    {
        $this->id_registro = $id;
        $registro = RegistroMedico::findOrFail($id);
        $this->fecha_consulta = $registro->fecha_consulta;
        $this->consulta = $registro->consulta;
        $this->receta = $registro->receta;
        $this->proxima_consulta = $registro->proxima_consulta;
        $this->modal = true;
    }

    public function mount($id_empleado)
    {
        $this->id_empleado = $id_empleado;
    }

    public function crear()
    {
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
        $this->id_registro = '';
        $this->fecha_consulta = '';
        $this->consulta = '';
        $this->receta = '';
        $this->proxima_consulta = '';
    }
}
