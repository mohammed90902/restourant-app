<?php

use App\Models\Table;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Category;
use App\Models\subCategory;
use App\Models\Food;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    // 1. Create Users
    $admin = User::firstOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => 1 // Admin
        ]
    );

    $waiter = User::firstOrCreate(
        ['email' => 'waiter@example.com'],
        [
            'name' => 'John Waiter',
            'password' => Hash::make('password'),
            'role' => 2 // Waiter
        ]
    );

    $chef = User::firstOrCreate(
        ['email' => 'chef@example.com'],
        [
            'name' => 'Gordon Chef',
            'password' => Hash::make('password'),
            'role' => 3 // Chef
        ]
    );

    echo "Users created: admin@example.com, waiter@example.com, chef@example.com (password: password)\n";

    // 2. Create Categories & SubCategories
    $mainDish = Category::create([
        'name_en' => 'Main Courses',
        'name_ar' => 'الأطباق الرئيسية',
        'name_ckb' => 'خواردنی سەرەکی',
        'image' => 'assets/images/categories/main.png',
        'user_id' => $admin->id
    ]);

    $drinks = Category::create([
        'name_en' => 'Drinks',
        'name_ar' => 'مشروبات',
        'name_ckb' => 'خواردنەوەکان',
        'image' => 'assets/images/categories/drinks.png',
        'user_id' => $admin->id
    ]);

    $steakSub = subCategory::create([
        'category_id' => $mainDish->id,
        'name_en' => 'Steaks',
        'name_ar' => 'ستيك',
        'name_ckb' => 'ستێک',
        'image' => 'assets/images/subcategories/steak.png',
        'user_id' => $admin->id
    ]);

    $pastaSub = subCategory::create([
        'category_id' => $mainDish->id,
        'name_en' => 'Pasta',
        'name_ar' => 'معكرونة',
        'name_ckb' => 'ماکەرۆنی',
        'image' => 'assets/images/subcategories/pasta.png',
        'user_id' => $admin->id
    ]);

    $coldDrinks = subCategory::create([
        'category_id' => $drinks->id,
        'name_en' => 'Cold Drinks',
        'name_ar' => 'مشروبات باردة',
        'name_ckb' => 'خواردنەوە ساردەکان',
        'image' => 'assets/images/subcategories/cola.png',
        'user_id' => $admin->id
    ]);

    echo "Categories and SubCategories created\n";

    // 3. Create Foods
    Food::create([
        'sub_category_id' => $steakSub->id,
        'name_en' => 'Ribeye Steak',
        'name_ar' => 'ستيك ريب آي',
        'name_ckb' => 'ستێکی ڕیب ئای',
        'price' => 25.00,
        'is_available' => 1,
        'user_id' => $admin->id
    ]);

    Food::create([
        'sub_category_id' => $pastaSub->id,
        'name_en' => 'Alfredo Pasta',
        'name_ar' => 'باستا ألفريدو',
        'name_ckb' => 'ئالفرێدۆ پاستا',
        'price' => 12.50,
        'is_available' => 1,
        'user_id' => $admin->id
    ]);

    Food::create([
        'sub_category_id' => $coldDrinks->id,
        'name_en' => 'Cola',
        'name_ar' => 'كولا',
        'name_ckb' => 'کۆلا',
        'price' => 2.00,
        'is_available' => 1,
        'user_id' => $admin->id
    ]);

    echo "Food items created\n";

    // 4. Create Tables
    $t1 = Table::firstOrCreate(['table_number' => '01'], ['status' => 'available', 'capacity' => 4]);
    $t2 = Table::firstOrCreate(['table_number' => '02'], ['status' => 'available', 'capacity' => 2]);
    $t3 = Table::firstOrCreate(['table_number' => '03'], ['status' => 'occupied', 'capacity' => 6]);

    echo "Tables created\n";

    // 5. Create Reservations
    Reservation::create([
        'name' => 'John Doe',
        'phone_number' => '07501234567',
        'hour' => '20:00',
        'chair' => '4',
        'table_id' => $t1->id,
        'user_id' => $waiter->id
    ]);

    echo "Sample data inserted successfully\n";

} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
