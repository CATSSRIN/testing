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
                'phone' => '+1-555-0100',
                'products' => [
                    ['name' => 'White Rice (25kg)', 'category' => 'Dry Goods', 'price' => 32.50, 'unit' => 'bag'],
                    ['name' => 'Pasta (500g)', 'category' => 'Dry Goods', 'price' => 3.20, 'unit' => 'pack'],
                    ['name' => 'Canned Tuna', 'category' => 'Canned Goods', 'price' => 2.80, 'unit' => 'can'],
                    ['name' => 'Cooking Oil (5L)', 'category' => 'Oils & Condiments', 'price' => 12.00, 'unit' => 'bottle'],
                    ['name' => 'Sugar (5kg)', 'category' => 'Dry Goods', 'price' => 8.50, 'unit' => 'bag'],
                ],
            ],
            [
                'name' => 'Marine Beverages Ltd.',
                'contact_name' => 'Sarah Lee',
                'email' => 'sarah@marinebev.com',
                'phone' => '+1-555-0200',
                'products' => [
                    ['name' => 'Mineral Water (1.5L)', 'category' => 'Beverages', 'price' => 1.50, 'unit' => 'bottle'],
                    ['name' => 'Orange Juice (1L)', 'category' => 'Beverages', 'price' => 3.80, 'unit' => 'carton'],
                    ['name' => 'Coffee (500g)', 'category' => 'Hot Drinks', 'price' => 14.00, 'unit' => 'pack'],
                    ['name' => 'Black Tea (100 bags)', 'category' => 'Hot Drinks', 'price' => 6.50, 'unit' => 'box'],
                ],
            ],
            [
                'name' => 'Cold Chain Dairy',
                'contact_name' => 'Mike Chen',
                'email' => 'mike@coldchain.com',
                'phone' => '+1-555-0300',
                'products' => [
                    ['name' => 'UHT Milk (1L)', 'category' => 'Dairy', 'price' => 2.20, 'unit' => 'carton'],
                    ['name' => 'Butter (500g)', 'category' => 'Dairy', 'price' => 5.50, 'unit' => 'pack'],
                    ['name' => 'Cheese Slices', 'category' => 'Dairy', 'price' => 4.80, 'unit' => 'pack'],
                    ['name' => 'Eggs (30 pcs)', 'category' => 'Dairy', 'price' => 9.00, 'unit' => 'tray'],
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
