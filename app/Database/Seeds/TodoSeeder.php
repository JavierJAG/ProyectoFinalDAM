<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run()
    {
        $this->call('UsersSeeder');
        $this->call('LocalidadesSeeder');
        $this->call('LogrosSeeder');
        // $this->call('EspeciesSeeder');
        // $this->call('CapturasSeeder');
        // $this->call('ZonasPescaSeeder');
        // $this->call('CompeticionesSeeder');
        // $this->call('ParticipacionesSeeder');
    }
}
