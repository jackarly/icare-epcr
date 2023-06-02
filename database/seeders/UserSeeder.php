<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserAdmin;
use App\Models\UserAmbulance;
use App\Models\UserComcen;
use App\Models\UserHospital;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin1 = User::create([
            'id' => '1000',
            'username' => 'test_admin',
            'password'  => Hash::make('test_admin'),  
            'user_type' => 'admin',
        ]);
        $admin1_profile = UserAdmin::create([
            'id' => '1000',
            'first_name' => 'john',
            'mid_name' => 'tan',
            'last_name' => 'doe',
            'email' => 'jantd@email.com',
            'contact_1' => '09121234567',
            'user_id' => '1000',
        ]);
        $admin2 = User::create([
            'id' => '1001',
            'username' => 'sample_admin',
            'password'  => Hash::make('sample_admin'),  
            'user_type' => 'admin',
        ]);
        $admin2_profile = UserAdmin::create([
            'id' => '1001',
            'first_name' => 'greg',
            'mid_name' => null,
            'last_name' => 'james',
            'email' => 'greggy_j@email.com',
            'contact_1' => '09131234567',
            'user_id' => '1001',
        ]);

        $ambulance1 = User::create([
            'id' => '1002',
            'username' => 'test_ambulance',
            'password'  => Hash::make('test_ambulance'),  
            'user_type' => 'ambulance',
        ]);
        $ambulance1_profile = UserAmbulance::create([
            'id' => '1002',
            'plate_no' => 'AZXC1098',
            'user_id' => '1002',
        ]);
        $ambulance2 = User::create([
            'id' => '1003',
            'username' => 'sample_ambulance',
            'password'  => Hash::make('sample_ambulance'),  
            'user_type' => 'ambulance',
        ]);
        $ambulance2_profile = UserAmbulance::create([
            'id' => '1003',
            'plate_no' => 'BMNC1795',
            'user_id' => '1003',
        ]);


        $comcen1 = User::create([
            'id' => '1004',
            'username' => 'test_comcen',
            'password'  => Hash::make('test_comcen'),  
            'user_type' => 'comcen',
        ]);
        $comcen1_profile = UserComcen::create([
            'id' => '1004',
            'first_name' => 'dave',
            'mid_name' => 'santos',
            'last_name' => 'yap',
            'email' => 'dsyap@email.com',
            'contact_1' => '09141234567',
            'user_id' => '1004',
        ]);
        $comcen2 = User::create([
            'id' => '1005',
            'username' => 'sample_comcen',
            'password'  => Hash::make('sample_comcen'),  
            'user_type' => 'comcen',
        ]);
        $comcen2_profile = UserComcen::create([
            'id' => '1005',
            'first_name' => 'sarah',
            'mid_name' => 'ramos',
            'last_name' => 'mati',
            'email' => 'sarah_rm@email.com',
            'contact_1' => '09151234567',
            'user_id' => '1005',
        ]);

        $hospital1 = User::create([
            'id' => '1006',
            'username' => 'test_hospital',
            'password'  => Hash::make('test_hospital'),  
            'user_type' => 'hospital',
        ]);
        $hospital1_profile = UserHospital::create([
            'id' => '1006',
            'hospital_name' => 'test hospital',
            'hospital_abbreviation' => 'TH',
            'hospital_address' => 'Butuan - Cagayan de Oro - Iligan Rd, Lapasan, CDO',
            'email' => 'th@email.com',
            'contact_1' => '09161234567',
            'contact_2' => '09171234567',
            'user_id' => '1006',
        ]);

        $hospital2 = User::create([
            'id' => '1007',
            'username' => 'cumc_hospital',
            'password'  => Hash::make('cumc_hospital'),  
            'user_type' => 'hospital',
        ]);
        $hospital2_profile = UserHospital::create([
            'id' => '1007',
            'hospital_name' => 'capital university medical center',
            'hospital_abbreviation' => 'CUMC',
            'hospital_address' => 'Butuan - Cagayan de Oro - Iligan Rd, Gusa, CDO',
            'email' => 'cumc@gmail.com',
            'contact_1' => '09269382719',
            'contact_2' => '09351000827',
            'user_id' => '1007',
        ]);

        $hospital3 = User::create([
            'id' => '1008',
            'username' => 'nmmc_hospital',
            'password'  => Hash::make('nmmc_hospital'),  
            'user_type' => 'hospital',
        ]);
        $hospital3_profile = UserHospital::create([
            'id' => '1008',
            'hospital_name' => 'Northern Mindanao Medical Center',
            'hospital_abbreviation' => 'NMMC',
            'hospital_address' => 'Capitol Rd, Cagayan de Oro',
            'email' => 'nmmc@gmail.com',
            'contact_1' => '09271627754',
            'contact_2' => '09182736578',
            'user_id' => '1008',
        ]);

        $hospital4 = User::create([
            'id' => '1009',
            'username' => 'jrbgh_hospital',
            'password'  => Hash::make('jrbgh_hospital'),  
            'user_type' => 'hospital',
        ]);
        $hospital4_profile = UserHospital::create([
            'id' => '1009',
            'hospital_name' => 'J.R. Borja General Hospital',
            'hospital_abbreviation' => 'JRBGH',
            'hospital_address' => 'Seriña St, Cagayan de Oro',
            'email' => 'jrbgh@gmail.com',
            'contact_1' => '09361298768',
            'contact_2' => '09350209227',
            'user_id' => '1009',
        ]);

        $hospital5 = User::create([
            'id' => '1010',
            'username' => 'mrxuh_hospital',
            'password'  => Hash::make('jrbgh_hospital'),  
            'user_type' => 'hospital',
        ]);
        $hospital5_profile = UserHospital::create([
            'id' => '1010',
            'hospital_name' => 'Maria Reyna - Xavier University Hospital',
            'hospital_abbreviation' => 'MRXUH',
            'hospital_address' => 'Hayes St, Cagayan de Oro',
            'email' => 'mrxuh@gmail.com',
            'contact_1' => '09162837461',
            'contact_2' => '09172839345',
            'user_id' => '1010',
        ]);
    }
}
