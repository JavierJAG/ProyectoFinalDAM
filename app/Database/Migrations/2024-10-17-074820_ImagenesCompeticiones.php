<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImagenesCompeticiones extends Migration
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
            'competicion_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'imagen_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('competicion_id', 'competiciones', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('imagen_id', 'imagenes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('imagenes_competiciones');
    }

    public function down()
    {
        $this->forge->dropTable('imagenes_competiciones');
    }
}
