<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Especies extends Migration
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
            'nombre_comun' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => FALSE
            ],
            'nombre_cientifico' => [
                'type' => 'VARCHAR',
                'constraint' => 255
            ],
            'tamano_minimo' => [
                'type' => 'FLOAT'
            ],
            'cupo_maximo' => [
                'type' => 'INT'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('especies');
    }

    public function down()
    {
        $this->forge->dropTable('especies');
    }
}
