<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Participaciones extends Migration
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
            'usuario_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned'=>TRUE,
                'null' => FALSE
            ],
            'captura_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned'=>TRUE
            ],
            'competicion_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned'=>TRUE
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('usuario_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('captura_id','capturas','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('competicion_id','competiciones','id','CASCADE','CASCADE');
        $this->forge->createTable('participaciones');
    }

    public function down()
    {
        $this->forge->dropTable('participaciones');
    }
}
