<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $file = storage_path('app/airline.csv');
        $rows = array_map('str_getcsv', file($file));

        unset($rows[0]); // remove header

        foreach ($rows as $row) {
            DB::table('air_lines')->insert([
                'name' => $this->removeSpecialChars($row[0]),
                'code' => $row[1],
                'awb_prefix' => $row[2],
                'country' => $row[3],
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function removeSpecialChars($string)
    {
        // Ensure valid UTF-8
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8, ISO-8859-1, ISO-8859-15');

        // Transliterate accents
        $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);

        // Remove symbols except letters, numbers, spaces
        $string = preg_replace('/[^A-Za-z0-9 ]/', '', $string);

        return trim($string);
    }

}