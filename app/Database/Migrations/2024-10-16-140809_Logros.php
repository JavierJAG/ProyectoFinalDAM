<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Logros extends Migration
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
            'nombre' => [
                'type' => 'VARCHAR',
                'constraint'=>255,
                'null' => FALSE
            ],
            'descripcion' => [
                'type' => 'TEXT',
                'null' => FALSE
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('logros');
    }

    public function down()
    {
        $this->forge->dropTable('logros');
    }
}
