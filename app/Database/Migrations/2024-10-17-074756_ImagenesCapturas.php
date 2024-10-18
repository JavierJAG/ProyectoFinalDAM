<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ImagenesCapturas extends Migration
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
            'captura_id' => [
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
        $this->forge->addForeignKey('captura_id', 'capturas', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('imagen_id', 'imagenes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('imagenes_capturas');
    }

    public function down()
    {
        $this->forge->dropTable('imagenes_capturas');
    }
}
