<?php

namespace App\Database\Seeds;

use App\Models\CapturaModel;
use CodeIgniter\Database\Seeder;

class CapturasSeeder extends Seeder
{
    public function run()
    {
        
        $data = [
            [
                'fecha_captura' => '2024-10-01 10:00:00',
                'nombre' => 'Captura 1',
                'descripcion' => 'Descripción de la captura 1.',
                'peso' => 5.5,
                'tamano' => 30.2,
                'usuario_id' => 1, 
                'especie_id' => 1, 
            ],
            [
                'fecha_captura' => '2024-10-02 11:30:00',
                'nombre' => 'Captura 2',
                'descripcion' => 'Descripción de la captura 2.',
                'peso' => 3.0,
                'tamano' => 25.0,
                'usuario_id' => 1,
                'especie_id' => 2,
            ],
            [
                'fecha_captura' => '2024-10-03 14:15:00',
                'nombre' => 'Captura 3',
                'descripcion' => 'Descripción de la captura 3.',
                'peso' => 7.2,
                'tamano' => 35.0,
                'usuario_id' => 2, 
                'especie_id' => 1,
            ],
            [
                'fecha_captura' => '2024-10-04 09:45:00',
                'nombre' => 'Captura 4',
                'descripcion' => 'Descripción de la captura 4.',
                'peso' => 2.5,
                'tamano' => 20.0,
                'usuario_id' => 1,
                'especie_id' => 3,
            ],
            [
                'fecha_captura' => '2024-10-05 12:00:00',
                'nombre' => 'Captura 5',
                'descripcion' => 'Descripción de la captura 5.',
                'peso' => 4.8,
                'tamano' => 28.0,
                'usuario_id' => 2,
                'especie_id' => 2,
            ],
        ];

        $capturasModel = new CapturaModel();
        $capturasModel->where('id>=0')->delete();
        foreach ($data as $captura) {
            $this->db->table('capturas')->insert($captura);
        }
    }
}

