<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    
        Customer::create([
            'name' => 'Dasun Prabath',
            'phone_number' => '0715432109'
        ]);

        Customer::create([
            'name' => 'Agnara Piris',
            'phone_number' => '1234567890'
        ]);

        Customer::create([
            'name' => 'Sumudu Dasun',
            'phone_number' => '0719667029'
        ]);

        Customer::create([
            'name' => 'Dasun Silva',
            'phone_number' => '0716427589'
        ]);

        Customer::create([
            'name' => 'Samantha Peris',
            'phone_number' => '0717823234'
        ]);

        Customer::create([
            'name' => 'Kavi Silva',
            'phone_number' => '0713141432'
        ]);
        Customer::create([
            'name' => 'Naduni Weerathunga',
            'phone_number' => '0712341767'
        ]);
        
    }
}
