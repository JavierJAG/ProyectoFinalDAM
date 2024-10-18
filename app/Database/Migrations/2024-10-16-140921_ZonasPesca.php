<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ZonasPesca extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ],
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'descripcion' => [
                'type' => 'TEXT'
            ],
            'coordenadas' => [
                'type' => 'POINT'
            ],
            'localidad_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned'=>TRUE
            ],
            
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('localidad_id','localidades','id','CASCADE','CASCADE');
        $this->forge->createTable('zonas_pesca');
    }

    public function down()
    {
        $this->forge->dropTable('zonas_pesca');
    }
}
