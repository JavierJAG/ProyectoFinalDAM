<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Capturas extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=>[
                'type'=>'INT',
                'constraint' => 10,
                'unsigned' => TRUE,
                'auto_increment'=>TRUE
            ],
            'fecha_captura'=>[
                'type'=>'DATETIME',
                'null'=>FALSE
            ],
            'nombre' => [
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>FALSE
            ],
            'descripcion' => [
                'type' => 'TEXT'
            ],
            'peso' => [
                'type' => 'FLOAT'
            ],
            'tamano' => [
                'type' => 'FLOAT'
            ],

            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned'=>TRUE,
                'null' => false,
            ],
            'especie_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned'=>TRUE
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('usuario_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('especie_id', 'especies', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('capturas');
    }

    public function down()
    {
        $this->forge->dropTable('capturas');
    }
}
