<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Partner;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        Partner::firstOrCreate(
            ['slug' => 'shopee'],
            [
                'name' => 'Shopee partner',
                'logo' => 'partners/logos/3jjTdFPO2IpLrRMgWUtPoWCyCzZ9YEWajd0XEA3H.jpg',
                'deskripsi' => 'Partner untuk semua online shope',
                'type' => 'media',
                'is_active' => true,
            ]
        );

        Partner::firstOrCreate(
            ['slug' => 'pt-3d-sejahtera'],
            [
                'name' => 'PT 3D SEJAHTERA',
                'logo' => 'partners/logos/NaA1mPqkCrJpf55uxQk6skMbPtWlfNO8VaZ1ouPV.jpg',
                'deskripsi' => 'PT 3D Sejahtera sebagai sponsor semua event amikom',
                'type' => 'sponsor',
                'is_active' => true,
            ]
        );

        Partner::firstOrCreate(
            ['slug' => 'pt-damar-sejahtera'],
            [
                'name' => 'PT DAMAR SEJAHTERA',
                'logo' => 'partners/logos/zF3wcfldM5yShZvsQdhuX7NQgLEXtb5OtrbsNlNG.jpg',
                'deskripsi' => 'PT DAMAR sebagai partner baru untuk mendukung event amikom',
                'type' => 'community',
                'is_active' => true,
            ]
        );

        Partner::firstOrCreate(
            ['slug' => 'pt-3d-makmur-sentosa'],
            [
                'name' => 'PT 3D Makmur Sentosa',
                'logo' => 'partners/logos/BeDoepnM4gNwJZFUHVKIrQ5rUYb3yZ2HsxH21RAW.jpg',
                'deskripsi' => null,
                'type' => 'community',
                'is_active' => true,
            ]
        );
    }
}