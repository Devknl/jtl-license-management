<?php

namespace Database\Seeders;

use App\Models\License;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LicenseSeeder extends Seeder
{
    public function run()
    {
        License::create([
            'license_key' => 'JTL-DEMO-12345',
            'customer_name' => 'Mustermann GmbH',
            'product_name' => 'JTL-Warenwirtschaft',
            'license_type' => 'subscription',
            'valid_until' => Carbon::now()->addYear(),
            'status' => 'active'
        ]);

        License::create([
            'license_key' => 'JTL-SHOP-67890', 
            'customer_name' => 'Beispiel AG',
            'product_name' => 'JTL-Shop',
            'license_type' => 'perpetual',
            'valid_until' => Carbon::now()->addMonths(6),
            'status' => 'active'
        ]);

        License::create([
            'license_key' => 'JTL-TEST-11111',
            'customer_name' => 'Testfirma GmbH',
            'product_name' => 'JTL-Testprodukt',
            'license_type' => 'subscription',
            'valid_until' => Carbon::now()->subMonth(),
            'status' => 'active'
        ]);

        License::create([
            'license_key' => 'JTL-PRO-22222',
            'customer_name' => 'Premium Kunde AG',
            'product_name' => 'JTL-Pro',
            'license_type' => 'subscription',
            'valid_until' => Carbon::now()->addYears(2),
            'status' => 'active'
        ]);
    }
}