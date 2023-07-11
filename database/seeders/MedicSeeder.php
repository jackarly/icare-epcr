<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Personnel;

class MedicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Personnel::create([
            'personnel_first_name'=> 'Khal',
            'personnel_mid_name'=> 'Dero',
            'personnel_last_name'=> 'Drogo',
            'personnel_other'=> null,
            'contact'=> '09123456789',
            'birthday'=> '1991-01-01',
            'sex'=> 'male',
            'personnel_type'=> 'medic',
        ]);
        
        Personnel::create([
            'personnel_first_name'=> 'James',
            'personnel_mid_name'=> 'Tan',
            'personnel_last_name'=> 'Watson',
            'personnel_other'=> null,
            'contact'=> '09123456789',
            'birthday'=> '1991-01-01',
            'sex'=> 'male',
            'personnel_type'=> 'medic',
        ]);
        
        Personnel::create([
            'personnel_first_name'=> 'Jenny',
            'personnel_mid_name'=> null,
            'personnel_last_name'=> 'David',
            'personnel_other'=> null,
            'contact'=> '09123456789',
            'birthday'=> '1991-01-01',
            'sex'=> 'female',
            'personnel_type'=> 'medic',
        ]);
        
        Personnel::create([
            'personnel_first_name'=> 'Jerico',
            'personnel_mid_name'=> 'Manda',
            'personnel_last_name'=> 'Kriti',
            'personnel_other'=> null,
            'contact'=> '09123456789',
            'birthday'=> '1991-01-01',
            'sex'=> 'male',
            'personnel_type'=> 'medic',
        ]);
        
        Personnel::create([
            'personnel_first_name'=> 'Richard',
            'personnel_mid_name'=> 'Mintal',
            'personnel_last_name'=> 'Gonzales',
            'personnel_other'=> null,
            'contact'=> '09123456789',
            'birthday'=> '1991-01-01',
            'sex'=> 'male',
            'personnel_type'=> 'medic',
        ]);
        
        Personnel::create([
            'personnel_first_name'=> 'Dave',
            'personnel_mid_name'=> 'Chua',
            'personnel_last_name'=> 'Virtudes',
            'personnel_other'=> null,
            'contact'=> '09193456789',
            'birthday'=> '1991-01-01',
            'sex'=> 'male',
            'personnel_type'=> 'driver',
        ]);
        
        Personnel::create([
            'personnel_first_name'=> 'Sammy Joe',
            'personnel_mid_name'=> 'Karing',
            'personnel_last_name'=> 'Tone',
            'personnel_other'=> null,
            'contact'=> '09193456789',
            'birthday'=> '1991-01-01',
            'sex'=> 'male',
            'personnel_type'=> 'driver',
        ]);
    }
}
