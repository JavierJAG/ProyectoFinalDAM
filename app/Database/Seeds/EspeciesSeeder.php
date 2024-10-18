<?php

namespace App\Database\Seeds;

use App\Models\EspecieModel;
use CodeIgniter\Database\Seeder;

class EspeciesSeeder extends Seeder
{
    public function run()
    {
        $especieModel = new EspecieModel();
        $especieModel->where("id>=0")->delete();
        for ($i = 1; $i <= 5; $i++) {
            $especieModel->insert([
                'nombre_comun' => 'pez ' . $i,
                'nombre_cientifico'=> 'pez cientifico ' . $i,
                'tamano_minimo'=> $i,
                'cupo_maximo'=>$i,
            ]);
        }
    }
}
