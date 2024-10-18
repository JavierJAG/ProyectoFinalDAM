<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Localidades extends Migration
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
            'PROVINCIA' => [
                'type' => 'ENUM',
                'constraint' => ['PONTEVEDRA', 'A CORUÑA', 'OURENSE', 'LUGO'],
                'null' => FALSE
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('localidades');
    }

    public function down()
    {
        $this->forge->dropTable('localidades');
    }
}
