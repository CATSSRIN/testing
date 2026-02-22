<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@shiporder.com'],
            [
                'name' => 'Admin',
                'company_name' => 'Ship Order Admin',
                'email' => 'admin@shiporder.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // Sample vendors and products
        $vendorData = [
            [
                'name' => 'FreshFoods Supply Co.',
                'contact_name' => 'John Smith',
                'email' => 'john@freshfoods.com',
                'phone' => '+62-21-5550100',
                'products' => [
                    ['name' => 'White Rice (25kg)', 'category' => 'Dry Goods', 'price' => 520000, 'unit' => 'bag'],
                    ['name' => 'Pasta (500g)', 'category' => 'Dry Goods', 'price' => 52000, 'unit' => 'pack'],
                    ['name' => 'Canned Tuna', 'category' => 'Canned Goods', 'price' => 45000, 'unit' => 'can'],
                    ['name' => 'Cooking Oil (5L)', 'category' => 'Oils & Condiments', 'price' => 190000, 'unit' => 'bottle'],
                    ['name' => 'Sugar (5kg)', 'category' => 'Dry Goods', 'price' => 135000, 'unit' => 'bag'],
                ],
            ],
            [
                'name' => 'Marine Beverages Ltd.',
                'contact_name' => 'Sarah Lee',
                'email' => 'sarah@marinebev.com',
                'phone' => '+62-21-5550200',
                'products' => [
                    ['name' => 'Mineral Water (1.5L)', 'category' => 'Beverages', 'price' => 24000, 'unit' => 'bottle'],
                    ['name' => 'Orange Juice (1L)', 'category' => 'Beverages', 'price' => 60000, 'unit' => 'carton'],
                    ['name' => 'Coffee (500g)', 'category' => 'Hot Drinks', 'price' => 225000, 'unit' => 'pack'],
                    ['name' => 'Black Tea (100 bags)', 'category' => 'Hot Drinks', 'price' => 105000, 'unit' => 'box'],
                ],
            ],
            [
                'name' => 'Cold Chain Dairy',
                'contact_name' => 'Mike Chen',
                'email' => 'mike@coldchain.com',
                'phone' => '+62-21-5550300',
                'products' => [
                    ['name' => 'UHT Milk (1L)', 'category' => 'Dairy', 'price' => 35000, 'unit' => 'carton'],
                    ['name' => 'Butter (500g)', 'category' => 'Dairy', 'price' => 88000, 'unit' => 'pack'],
                    ['name' => 'Cheese Slices', 'category' => 'Dairy', 'price' => 77000, 'unit' => 'pack'],
                    ['name' => 'Eggs (30 pcs)', 'category' => 'Dairy', 'price' => 144000, 'unit' => 'tray'],
                ],
            ],
        ];

        foreach ($vendorData as $vd) {
            $products = $vd['products'];
            unset($vd['products']);
            $vendor = Vendor::firstOrCreate(['name' => $vd['name']], $vd);
            foreach ($products as $pd) {
                Product::firstOrCreate(
                    ['vendor_id' => $vendor->id, 'name' => $pd['name']],
                    array_merge($pd, ['vendor_id' => $vendor->id, 'is_active' => true])
                );
            }
        }
    }
}
