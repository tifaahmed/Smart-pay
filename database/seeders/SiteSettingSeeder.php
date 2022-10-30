<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SiteSetting;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            SiteSetting::all()->delete();
        } catch (\Exception $e) {
            SiteSetting::query()->forceDelete();
        }


        SiteSetting::create( [
            'item_key' => 'site_logo',
            'item' => 'admin@admin.com',
            'item_type' => 'image',
        ]);
        SiteSetting::create( [
            'item_key' => 'site_domain',
            'item' => 'https://smart.lic2.com/',
            'item_type' => 'string',
        ]);
        SiteSetting::create( [
            'item_key' => 'site_name_en',
            'item' => 'smart pay',
            'item_type' => 'string',
        ]);
        SiteSetting::create( [
            'item_key' => 'site_name_ar',
            'item' => 'ادفع بذكاء',
            'item_type' => 'string',
        ]);
        SiteSetting::create( [
            'item_key' => 'site_subscription',
            'item' => 10,
            'item_type' => 'integer',
        ]);
        SiteSetting::create( [
            'item_key' => 'site_email',
            'item' => 'smartpay2525@gmail.com',
            'item_type' => 'integer',
        ]);
        SiteSetting::create( [
            'item_key' => 'site_phone',
            'item' => '01157751549',
            'item_type' => 'integer',
        ]);
    }
}
