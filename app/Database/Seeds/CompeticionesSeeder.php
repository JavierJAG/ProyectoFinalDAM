<?php

namespace App\Database\Seeds;

use App\Models\CompeticionModel;
use CodeIgniter\Database\Seeder;

class CompeticionesSeeder extends Seeder
{
    public function run()
    {
  
        $data = [
            [
                'nombre' => 'Competencia de Pesca 2024',
                'descripcion' => 'Una emocionante competencia de pesca para todos los pescadores.',
                'fecha_inicio' => '2024-11-01 08:00:00',
                'fecha_fin' => '2024-11-01 17:00:00',
                'zona_id' => 1, 
                'usuario_id' => 1, 
            ],
            [
                'nombre' => 'Torneo de Pesca de Verano',
                'descripcion' => 'Un torneo especial durante el verano.',
                'fecha_inicio' => '2024-12-15 09:00:00',
                'fecha_fin' => '2024-12-15 18:00:00',
                'zona_id' => 2, 
                'usuario_id' => 2,
            ],
            [
                'nombre' => 'Campeonato Nacional de Pesca',
                'descripcion' => 'El campeonato más esperado del año.',
                'fecha_inicio' => '2025-01-10 07:30:00',
                'fecha_fin' => '2025-01-10 16:00:00',
                'zona_id' => 1,
                'usuario_id' => 1,
            ],
            [
                'nombre' => 'Competencia de Invierno',
                'descripcion' => 'Desafía a tus amigos en esta competencia de invierno.',
                'fecha_inicio' => '2025-02-05 08:30:00',
                'fecha_fin' => '2025-02-05 15:30:00',
                'zona_id' => 3, 
                'usuario_id' => 1,
            ],
            [
                'nombre' => 'Maratón de Pesca 2024',
                'descripcion' => 'Pesca durante 24 horas y gana increíbles premios.',
                'fecha_inicio' => '2024-10-21 00:00:00',
                'fecha_fin' => '2024-10-22 00:00:00',
                'zona_id' => 2,
                'usuario_id' => 2,
            ],
        ];

        $competicionModel = new CompeticionModel();
        $competicionModel->where("id>=0")->delete();
        foreach ($data as $competicion) {
            $this->db->table('competiciones')->insert($competicion);
        }
    }
}
