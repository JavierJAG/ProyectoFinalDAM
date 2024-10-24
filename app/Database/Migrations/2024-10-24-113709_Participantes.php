<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Participantes extends Migration
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
            'competicion_id' => [
                'type' => 'INT',
                'constraint' => 10,
                'unsigned'=>TRUE
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('usuario_id','users','id','CASCADE','CASCADE');
        $this->forge->addForeignKey('competicion_id','competiciones','id','CASCADE','CASCADE');
        $this->forge->createTable('participantes');
    }

    public function down()
    {
        $this->forge->dropTable('participantes');
    }
}
