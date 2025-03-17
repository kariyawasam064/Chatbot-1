<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('group')->insert([ 
            [ 
                'group_name' => 'Group 1', 
                'group_code' => 'G001', 
                'address' => '123 Main St, Colombo', 
                'contact_number' => '1234567890', 
                'created_at' => now(), 
                'updated_at' => now(), 
            ], 
            [ 
                'group_name' => 'Group 2', 
                'group_code' => 'G002', 
                'address' => '456 Another St, Kandy', 
                'contact_number' => '0987654321', 
                'created_at' => now(), 
                'updated_at' => now(), 
            ], 
            [ 
                'group_name' => 'Group 3', 
                'group_code' => 'G003', 
                'address' => '789 Third St, Galle', 
                'contact_number' => '1357924680', 
                'created_at' => now(), 
                'updated_at' => now(), 
            ],
            [
                'group_name' => 'Group 4',
                'group_code' => 'G004',
                'address' => '101 Fourth St, Jaffna',
                'contact_number' => '2468013579',
                'created_at' => now(),
                'updated_at' => now(), 
            ],
            [
                'group_name' => 'Group 5',
                'group_code' => 'G005',
                'address' => '202 Fifth St, Matara',
                'contact_number' => '3698521470',
                'created_at' => now(),
                'updated_at' => now(), 
            ],
            [
                'group_name' => 'Group 6',
                'group_code' => 'G006',
                'address' => '303 Sixth St, Nuwara Eliya',
                'contact_number' => '4827039165',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_name' => 'Group 7',
                'group_code' => 'G007',
                'address' => '404 Seventh St, Anuradhapura',
                'contact_number' => '5956148273',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_name' => 'Group 8',
                'group_code' => 'G008',
                'address' => '505 Eighth St, Polonnaruwa',
                'contact_number' => '6087259384',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_name' => 'Group 9',
                'group_code' => 'G009',
                'address' => '606 Ninth St, Trincomalee',
                'contact_number' => '7198360495',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_name' => 'Group 10',
                'group_code' => 'G010',
                'address' => '707 Tenth St, Batticaloa',
                'contact_number' => '8209471586',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_name' => 'Group 11',
                'group_code' => 'G011',
                'address' => '808 Eleventh St, Ampara',
                'contact_number' => '9310582697',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_name' => 'Group 12',
                'group_code' => 'G012',
                'address' => '909 Twelfth St, Badulla',
                'contact_number' => '0421536879',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group_name' => 'Group 13',
                'group_code' => 'G013',
                'address' => '1010 Thirteenth St, Hambantota',
                'contact_number' => '1532647980',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
