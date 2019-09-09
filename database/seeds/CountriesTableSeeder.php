<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countriesDefaultList = config('countries');
        foreach ($countriesDefaultList as $code => $name) {
            DB::table('countries')->insert([
                'name' => $name,
                'code' => $code
            ]);
        }
    }
}
