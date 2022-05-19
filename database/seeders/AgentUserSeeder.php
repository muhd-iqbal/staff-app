<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'id' => 1,
                'name' => 'Admin',
                'icno' => '000000000000',
                'email' => 'admin@inspirazs.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'phone' => '0000000000',
                'department_id' => 1,
                'position_id' => 2,
                'joined_at' => '1970-01-01',
                'isAdmin' => 1,
                'created_at' => NOW()
            ],
        );
    }
}
