<?php

namespace App\Database\Seeds;

use App\Models\LocalidadModel;
use CodeIgniter\Database\Seeder;

class LocalidadesSeeder extends Seeder
{
    public function run()
    {
        $localidadModel = new LocalidadModel();
        $localidadModel->where('id>=0')->delete();
        $localidades = [
            ['nombre' => 'A Coruña', 'PROVINCIA' => 'A Coruña'],
            ['nombre' => 'Lugo', 'PROVINCIA' => 'Lugo'],
            ['nombre' => 'Ourense', 'PROVINCIA' => 'Ourense'],
            ['nombre' => 'Pontevedra', 'PROVINCIA' => 'Pontevedra'],
            ['nombre' => 'Santiago de Compostela', 'PROVINCIA' => 'A Coruña'],
            ['nombre' => 'Ferrol', 'PROVINCIA' => 'A Coruña'],
            ['nombre' => 'Lugo de Llanera', 'PROVINCIA' => 'Lugo'],
            ['nombre' => 'Ribeira', 'PROVINCIA' => 'A Coruña'],
            ['nombre' => 'Vigo', 'PROVINCIA' => 'Pontevedra'],
            ['nombre' => 'Ponteareas', 'PROVINCIA' => 'Pontevedra'],
            ['nombre' => 'Tui', 'PROVINCIA' => 'Pontevedra'],
            ['nombre' => 'Burela', 'PROVINCIA' => 'Lugo'],
            ['nombre' => 'Monforte de Lemos', 'PROVINCIA' => 'Lugo'],
            ['nombre' => 'Vilagarcía de Arousa', 'PROVINCIA' => 'Pontevedra'],
            ['nombre' => 'Cee', 'PROVINCIA' => 'A Coruña'],
            ['nombre' => 'Cangas', 'PROVINCIA' => 'Pontevedra'],
            ['nombre' => 'O Barco de Valdeorras', 'PROVINCIA' => 'Ourense'],
            ['nombre' => 'O Porriño', 'PROVINCIA' => 'Pontevedra'],
            ['nombre' => 'A Pobra do Caramiñal', 'PROVINCIA' => 'A Coruña'],
            ['nombre' => 'Rianxo', 'PROVINCIA' => 'A Coruña'],
            ['nombre' => 'Carballo', 'PROVINCIA' => 'A Coruña'],
        ];
        foreach ($localidades as $localidad) {
            $localidadModel->insert($localidad);
        }
    
    }
}
