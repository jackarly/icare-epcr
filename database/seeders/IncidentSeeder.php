<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Incident;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Incident::create([
            'id'=> '1000',
            'nature_of_call'=> 'emergency',
            'incident_type'=> 'medical',
            'incident_location'=> 'Gusa, CDO',
            'area_type'=> 'residential',
            'caller_first_name'=> 'June',
            'caller_mid_name'=> null,
            'caller_last_name'=> 'Bolao',
            'caller_number'=> '09193829304',
            'no_of_persons_involved'=> '1',
            'incident_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
            'injuries_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
        ]);
        
        Incident::create([
            'nature_of_call'=> 'emergency',
            'incident_type'=> 'trauma',
            'incident_location'=> 'Lapasan, CDO',
            'area_type'=> 'commercial',
            'caller_first_name'=> 'Henry',
            'caller_mid_name'=> 'Bagaba',
            'caller_last_name'=> 'Banda',
            'caller_number'=> '09193829304',
            'no_of_persons_involved'=> '1',
            'incident_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
            'injuries_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
        ]);
        
        Incident::create([
            'nature_of_call'=> 'emergency',
            'incident_type'=> 'medical',
            'incident_location'=> 'Consolacion, CDO',
            'area_type'=> 'road/street',
            'caller_first_name'=> 'Erik',
            'caller_mid_name'=> null,
            'caller_last_name'=> 'Torres',
            'caller_number'=> '09193829304',
            'no_of_persons_involved'=> '1',
            'incident_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
            'injuries_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
        ]);
        
        Incident::create([
            'nature_of_call'=> 'emergency',
            'incident_type'=> 'trauma',
            'incident_location'=> 'Nazareth, CDO',
            'area_type'=> 'recreation',
            'caller_first_name'=> 'Jade',
            'caller_mid_name'=> null,
            'caller_last_name'=> 'Carlos',
            'caller_number'=> '09193829304',
            'no_of_persons_involved'=> '1',
            'incident_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
            'injuries_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
        ]);
        
        Incident::create([
            'nature_of_call'=> 'emergency',
            'incident_type'=> 'medical',
            'incident_location'=> 'Balubal, CDO',
            'area_type'=> 'residential',
            'caller_first_name'=> 'Ginny',
            'caller_mid_name'=> null,
            'caller_last_name'=> 'manatasa',
            'caller_number'=> '09193829304',
            'no_of_persons_involved'=> '1',
            'incident_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
            'injuries_details'=> 'Pellentesque mauris ex, molestie at dignissim vel, aliquam a nunc. Etiam vestibulum lorem ut neque tristique, at aliquam quam pellentesque. Maecenas at magna ut nulla imperdiet porttitor.',
        ]);
    }
}
