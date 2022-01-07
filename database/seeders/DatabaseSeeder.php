<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\Order;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            ['name' => 'Tiada', 'created_at'=>NOW()],
            ['name' => 'Sumber Manusia', 'created_at'=>NOW()],
            ['name' => 'Rekaan Grafik', 'created_at'=>NOW()],
            ['name' => 'Teknologi Maklumat', 'created_at'=>NOW()],
            ['name' => 'Pemasaran / Media Sosial', 'created_at'=>NOW()],
        ]);
        DB::table('positions')->insert([
            ['name' => 'Owner', 'created_at'=>NOW()],
            ['name' => 'Admin', 'created_at'=>NOW()],
            ['name' => 'Staf Tetap', 'created_at'=>NOW()],
            ['name' => 'Staf Kontrak', 'created_at'=>NOW()],
            ['name' => 'Praktikal / LI', 'created_at'=>NOW()],
        ]);
        // Department::factory(5)->create();
        User::factory(1)->create();
        Order::factory(5)->create();
        DB::table('leave_types')->insert([
            ['name' => 'Cuti Tahunan', 'approval'=>1],
            ['name' => 'Cuti Kecemasan', 'approval'=>1],
            ['name' => 'Cuti Sakit', 'approval'=>1],
            ['name' => 'Cuti Tanpa Gaji', 'approval'=>1],
            ['name' => 'Cuti Bersalin', 'approval'=>1],
            ['name' => 'Lain-lain', 'approval'=>1],
        ]);
        Leave::factory(5)->create();
    }
}
