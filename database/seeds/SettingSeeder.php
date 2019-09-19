<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            Setting::create([
                'name' => 'periodDivider',
                'value' => 10
            ]);

            Setting::create([
                'name' => 'typeDivider',
                'value' => 'month'
            ]);
        });
    }
}
