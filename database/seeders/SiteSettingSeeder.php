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
            'id' => '1',
            'item_key' => 'site_logo',
            'item' => 'admin@admin.com',
            'item_type' => 'image',
        ]);
        SiteSetting::create( [
            'id' => '2',
            'item_key' => 'site_domain',
            'item' => 'https://smart.lic2.com/',
            'item_type' => 'string',
        ]);
        SiteSetting::create( [
            'id' => '3',
            'item_key' => 'site_name_en',
            'item' => 'smart pay',
            'item_type' => 'string',
        ]);
        SiteSetting::create( [
            'id' => '4',
            'item_key' => 'site_name_ar',
            'item' => 'ادفع بذكاء',
            'item_type' => 'string',
        ]);
        SiteSetting::create( [
            'id' => '5',
            'item_key' => 'site_email',
            'item' => 'smartpay2525@gmail.com',
            'item_type' => 'integer',
        ]);
        SiteSetting::create( [
            'id' => '6',
            'item_key' => 'site_phone',
            'item' => '01157751549',
            'item_type' => 'integer',
        ]);
        SiteSetting::create( [
            'id' => '7',
            'item_key' => 'subscription_monthly_price',
            'item' => 10,
            'item_type' => 'integer',
        ]);
        SiteSetting::create( [
            'id' => '8',
            'item_key' => 'subscription_free_months_price',
            'item' => 10,
            'item_type' => 'integer',
        ]);
    }
}
