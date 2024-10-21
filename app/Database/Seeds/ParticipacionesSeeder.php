<?php

namespace App\Database\Seeds;

use App\Models\ParticipacionModel;
use CodeIgniter\Database\Seeder;

class ParticipacionesSeeder extends Seeder
{
    public function run()
    {
       
        $data = [
            [
                'usuario_id' => 1, 
                'captura_id' => 1, 
                'competicion_id' => 1, 
            ],
            [
                'usuario_id' => 2,
                'captura_id' => 2,
                'competicion_id' => 1,
            ],
            [
                'usuario_id' => 1,
                'captura_id' => 3,
                'competicion_id' => 2,
            ],
            [
                'usuario_id' => 3,
                'captura_id' => 1,
                'competicion_id' => 3,
            ],
            [
                'usuario_id' => 2,
                'captura_id' => 4,
                'competicion_id' => 3,
            ],
            [
                'usuario_id' => 1,
                'captura_id' => 2,
                'competicion_id' => 4,
            ],
        ];

        $participacionModel = new ParticipacionModel();
        $participacionModel->where('id>=0')->delete();
        foreach ($data as $participacion) {
            $this->db->table('participaciones')->insert($participacion);
        }
    }
}
