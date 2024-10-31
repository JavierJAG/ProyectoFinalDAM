<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge;
use CodeIgniter\Database\Migration;

class AddInfoToUsers extends Migration
{
    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up()
    {
        $fields = [
            'nombre' => ['type' => 'VARCHAR', 'constraint' => '100', 'null' => true],
        ];
        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $fields = [
            'nombre',
        ];
        $this->forge->dropColumn($this->tables['users'], $fields);
    }
}
