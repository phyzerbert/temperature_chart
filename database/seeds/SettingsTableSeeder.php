<?php

use Illuminate\Database\Seeder;

use App\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'top_limit' => 37.5,
            'chart_top' => 38.5,
            'chart_bottom' => 36.0,
        ]);
    }
}
