<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Salidas extends Migration
{
    public function up()
    {
        // Define the schema for the 'fishing_events' table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'fecha' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'titulo' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'usuario_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],
            'zona_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => false,
            ],

        ]);

        $this->forge->addPrimaryKey('id');

        $this->forge->addForeignKey('usuario_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('zona_id', 'zonas_pesca', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('salidas');
    }

    public function down()
    {
        $this->forge->dropTable('salidas');
    }
}
