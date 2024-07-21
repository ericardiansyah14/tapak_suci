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

        $lastCabang = Cabang::orderBy('id', 'desc')->first();
        $lastKode = $lastCabang ? intval(substr($lastCabang->kode_cabang, 3)) : 0;
        $newKode = 'CBG' . str_pad($lastKode + 1, 3, '0', STR_PAD_LEFT);

        Cabang::create([
            'nomor_induk_cabang' => $newKode,
            'nama_cabang' => 'Cabang 1',
            'alamat_cabang' => 'Jl. Contoh Alamat 1',
            'pelatih_cabang' => 'yanto',
        ]);

        User::create([
            'name' => 'testing',
            'email' => 'tes@gmail.com',
            'password' => bcrypt('12345'),
        ]);

    }
}
