<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        //  $file = storage_path('app/airports.csv');
        // $rows = array_map('str_getcsv', file($file));

        // unset($rows[0]); // remove header

        // foreach ($rows as $row) {
        //     DB::table('airports')->insert([
        //         'name' => $this->removeSpecialChars($row[0]),
        //         'country' => $row[1],
        //         'code' => $row[2],
        //         'status' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }

    public function removeSpecialChars($string)
    {
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    }
}
