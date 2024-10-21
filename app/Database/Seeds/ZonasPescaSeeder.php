<?php

namespace App\Database\Seeds;

use App\Models\ZonaPescaModel;
use CodeIgniter\Database\Seeder;

class ZonasPescaSeeder extends Seeder
{
    public function run()
    {
        // Datos de ejemplo para las zonas de pesca
        $data = [
            [
                'nombre' => 'Zona 1',
                'descripcion' => 'Descripción de la zona 1.',
                'localidad_id' => 1, 
                'usuario_id' => 1, 
            ],
            [
                'nombre' => 'Zona 2',
                'descripcion' => 'Descripción de la zona 2.',
                'localidad_id' => 1,
                'usuario_id' => 1,
            ],
            [
                'nombre' => 'Zona 3',
                'descripcion' => 'Descripción de la zona 3.',
                'localidad_id' => 2,
                'usuario_id' => 1,
            ],
            [
                'nombre' => 'Zona 4',
                'descripcion' => 'Descripción de la zona 4.',
                'localidad_id' => 2,
                'usuario_id' => 1,
            ],
            [
                'nombre' => 'Zona 5',
                'descripcion' => 'Descripción de la zona 5.',
                'localidad_id' => 3,
                'usuario_id' => 1,
            ],
        ];
        $zonaPescaModel = new ZonaPescaModel();
        $zonaPescaModel->where('id>=0')->delete();
        foreach ($data as $zona) {
            $this->db->table('zonas_pesca')->insert($zona);
        }
    }
}
