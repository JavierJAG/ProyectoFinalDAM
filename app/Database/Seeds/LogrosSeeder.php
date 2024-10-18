<?php

namespace App\Database\Seeds;

use App\Models\LogroModel;
use CodeIgniter\Database\Seeder;

class LogrosSeeder extends Seeder
{
    public function run()
    {
        $logroModel = new LogroModel();
        $logroModel->where('id>=0')->delete();
        for ($i = 1; $i <= 5; $i++) {
            $logroModel->insert([
                'nombre' => 'nombre logro ' . $i,
                'descripcion'=> 'descripcion logro ' . $i
            ]);
        }
    }
}
