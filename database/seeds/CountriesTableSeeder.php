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

        DB::table('cities')->insert([
            'name' => 'Sarajevo',
            'code' => 'Sa'
        ]);

        DB::table('industry_types')->insert([
            'name' => 'Chemical Industry'
        ]);

        DB::table('contact_types')->insert([
            'name' => 'Phone'
        ]);

        DB::table('contact_types')->insert([
            'name' => 'Facebook'
        ]);
    }
}
