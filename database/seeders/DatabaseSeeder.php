<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\CentroCosto;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(CentroCostoSeeder::class);
        $this->call(RegionSeeder::class);
        $this->call(DepartamentoSeeder::class);
        $this->call(EtniaSeeder::class);
        $this->call(GrupoSanguineoSeeder::class);
        $this->call(GeneroSeeder::class);
        $this->call(NacionalidadSeeder::class);
        $this->call(ColegioSeeder::class);
        $this->call(ProgramaSeeder::class);
        $this->call(ActividadSeed::class);
        $this->call(ProductoSeeder::class);
        $this->call(SubproductoSeed::class);
        $this->call(ControlSeeder::class);
        $this->call(EstadoCivilSeeder::class);
        $this->call(TipoContratacionSeeder::class);
        $this->call(PlazaSeeder::class);
        $this->call(FuenteFinanciamientoSeeder::class);
        $this->call(EspecialidadSeeder::class);
        $this->call(RegistroAcademicoSeeder::class);
        $this->call(TipoServicioSeeder::class);
        $this->call(BonificacionSeeder::class);
        $this->call(RequisitoSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(DependenciaSubproductoSeeder::class);
        $this->call(TipoLicenciaSeeder::class);
        $this->call(TipoVehiculoSeeder::class);
        $this->call(TipoDeudaSeeder::class);
        $this->call(TipoViviendaSeeder::class);
        $this->call(EtapaAplicacionSeeder::class);
        /* $this->call(BonoRenglonSeeder::class); */
        /* $this->call(CatalogoPuestoSeeder::class); */

        \App\Models\User::factory()->create([
            'name' => 'Sergio Daniel Gonzáles López',
            'email' => 'sdgonzales@conred.org.gt',
            'password' => bcrypt('Admin123')
        ])->assignRole('Súper Administrador');
    }
}
