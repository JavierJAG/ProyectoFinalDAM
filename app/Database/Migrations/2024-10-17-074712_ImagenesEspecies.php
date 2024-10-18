<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImagenesEspecies extends Migration
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
            'especie_id' => [
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
        $this->forge->addForeignKey('especie_id', 'especies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('imagen_id', 'imagenes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('imagenes_especies');
    }

    public function down()
    {
        $this->forge->dropTable('imagenes_especies');
    }
}
