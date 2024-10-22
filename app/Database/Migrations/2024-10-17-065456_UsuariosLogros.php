<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UsuariosLogros extends Migration
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
            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE
            ],
            'logro_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'competicion_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned' => TRUE
            ],
            'fecha_obtencion' => [
                'type' => 'DATETIME'
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('usuario_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('logro_id', 'logros', 'id', 'CASCADE', 'CASCADE');      
        $this->forge->addForeignKey('competicion_id','competiciones','id','CASCADE','CASCADE');
        $this->forge->createTable('usuarios_logros');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios_logros');
    }
}
