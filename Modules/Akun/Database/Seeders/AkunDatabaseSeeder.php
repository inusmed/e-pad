<?php

namespace Modules\Akun\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AkunDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(\Modules\Akun\Database\Seeders\PenggunaDatabaseSeeder::class);
    }
}
