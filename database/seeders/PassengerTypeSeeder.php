<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use App\Models\Admin\PassengerType;

class PassengerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $types = [
            [
                'title' => 'Adult',
                'code' => 'ADT',
                'status' => 1
            ],
            [
                'title' => 'Accompained Child',
                'code' => 'CNN',
                'status' => 1
            ],
            [
                'title' => 'Infant without a Seat',
                'code' => 'INF',
                'status' => 1
            ]
        ];

        foreach ($types as $type) {
            PassengerType::create([
                'title' => $type['title'],
                'code' => $type['code'],
                'status' => $type['status']
            ]);
        }
    }

}