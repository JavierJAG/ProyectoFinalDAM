<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TodoSeeder extends Seeder
{
    public function run()
    {
        $this->call('EspeciesSeeder');
        $this->call('LocalidadesSeeder');
        $this->call('LogrosSeeder');
    }
}
