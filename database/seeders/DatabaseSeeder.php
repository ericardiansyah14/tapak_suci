<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\Cabang;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       

        User::create([
            'name' => 'Pimda 114',
            'username' => 'Adminnew',
            'password' => bcrypt('12345'),
        ]);

    }
}
