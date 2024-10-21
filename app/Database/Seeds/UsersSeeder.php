<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory as Faker;

class UsersSeeder extends Seeder
{
    public function run()
    {
     
        $data = [
            // [
            //     'username' => 'admin',
            
            //     'active'   => 1,
            //     'created_at' => date('Y-m-d H:i:s'),
            //     'updated_at' => date('Y-m-d H:i:s'),
            // ],
            [
                'username' => 'user1',
           
                'active'   => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username' => 'user2',
              
                'active'   => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        
        ];

  
        foreach ($data as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}
