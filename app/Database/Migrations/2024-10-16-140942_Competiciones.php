<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Competiciones extends Migration
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
                'type'=>'VARCHAR',
                'constraint'=>255,
                'null'=>FALSE
            ],
            'descripcion' => [
                'type'=>'TEXT',
                'null'=>FALSE
            ],
            'fecha_inicio'=>[
                'type'=>'DATETIME',
                'null'=>FALSE
            ],
            'fecha_fin'=>[
                'type'=>'DATETIME',
                'null'=>FALSE
            ],
            'zona_id'=>[
                'type' => 'INT',
                'constraint' => 10,
                'unsigned'=>TRUE
            ]
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('zona_id','zonas_pesca','id','CASCADE','CASCADE');
        $this->forge->createTable('competiciones');
    }

    public function down()
    {
        $this->forge->dropTable('competiciones');
    }
}
