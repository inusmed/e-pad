<?php namespace Modules\Akun\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Akun\Entities\User;
use Modules\Akun\Entities\Companies;
use Modules\Akun\Entities\UserCompany;

class PenggunaDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* Companies */
        Companies::create([
            'id'        => 'X3B196590X9',
            'name'      => 'BPKAD KAB KARO',
            'address'   => 'Jln. Djamin Ginting No. 17 Kabanjahe Sumatera Utara ',
            'region'    => 'KARO',
            'district'  => 'KABANJAHE',
            'phone'     => '(0628) 324456',
            'leader'    => 'ANDREASTA TARIGAN',
            'description'=> 'e-PAD KABUPATEN KARO',
            'enabled'   => 't'
        ]);
        
        User::create([
            'id'        => 1,
            'company_id'=> 'X3B196590X9',
            'uuid'      => '01e3910a-9fa6-4a18-a425-cb74f56e6038',
            'name'      => 'ANDRYANTO., S.KOM',
            'username'  => 'andriynto',
            'email'     => 'andriyanto@indonusamedia.co.id',
            'password'  => '$2y$10$VksJ7AQe5WPxxmVK8tlM8OMxJ7.PiK9inkJV8zgQAK2yl9NL3p5j.',
            'remember_token'    => 'hRxbyG6Mwd3OB60IyYTyM60vxFR1W1EXHcwOXaVJxB4dNlf3rdOsoEjvEYsh',
            'picture'   => '1558857401_5cea46b9d40b6.png',
            'last_logged_in_at' => '2019-10-21 21:23:11',
            'enabled'   => 't',
            'code'      => '664269',
            'expired_in'=> '2019-08-08 02:40:09',
            'verify'    => 't',
            'suspend'   => 'f',
            'locale'    => 'id-ID'
        ]);
        
        UserCompany::insert([
            'user_id'   => 1,
            'company_id'=> 'X3B196590X9',
            'user_type' => 'super_administrator'
        ]);
    }
}