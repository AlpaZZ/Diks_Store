<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\TopUp;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin Users with NIM
        User::create([
            'name' => 'M. Raziq Alfarizi',
            'email' => 'raziq@diksstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567890',
            'nim' => '8020230273',
        ]);

        User::create([
            'name' => 'Alfarizki Ramadhan',
            'email' => 'alfarizki@diksstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567891',
            'nim' => '8020230220',
        ]);

        User::create([
            'name' => 'Yowananda Riyan',
            'email' => 'yowan@diksstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567892',
            'nim' => '8020230201',
        ]);

        User::create([
            'name' => 'Fajar Uli Adimas',
            'email' => 'dimas@diksstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567893',
            'nim' => '8020230156',
        ]);

        User::create([
            'name' => 'Padika Pratama',
            'email' => 'padika@diksstore.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081234567894',
            'nim' => '8020230120',
        ]);

        // Create Sample User
        User::create([
            'name' => 'User Demo',
            'email' => 'user@diksstore.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'phone' => '081234567899',
        ]);

        // Create Categories
        $categories = [
            [
                'name' => 'Mobile Legends',
                'slug' => 'mobile-legends',
                'description' => 'Akun Mobile Legends Bang Bang dengan berbagai level dan skin',
                'is_active' => true,
            ],
            [
                'name' => 'Free Fire',
                'slug' => 'free-fire',
                'description' => 'Akun Garena Free Fire dengan koleksi skin dan bundle menarik',
                'is_active' => true,
            ],
            [
                'name' => 'PUBG Mobile',
                'slug' => 'pubg-mobile',
                'description' => 'Akun PUBG Mobile dengan berbagai skin dan item langka',
                'is_active' => true,
            ],
            [
                'name' => 'Genshin Impact',
                'slug' => 'genshin-impact',
                'description' => 'Akun Genshin Impact dengan karakter 5 star dan weapon',
                'is_active' => true,
            ],
            [
                'name' => 'Valorant',
                'slug' => 'valorant',
                'description' => 'Akun Valorant dengan berbagai skin senjata premium',
                'is_active' => true,
            ],
            [
                'name' => 'Clash of Clans',
                'slug' => 'clash-of-clans',
                'description' => 'Akun COC dengan berbagai Town Hall level',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Sample Products
        $products = [
            [
                'category_id' => 1,
                'name' => 'Akun ML Sultan - 100 Skin Hero + Mythic Glory',
                'description' => "Akun Mobile Legends Bang Bang Sultan!\n\n✅ 100+ Skin Hero (termasuk skin Collector & Legend)\n✅ Rank: Mythic Glory 1000+ Points\n✅ Hero: Semua hero unlock\n✅ Emblem: Max Level\n✅ Battle Points: 50.000+\n✅ Diamonds: 500+\n\nAkun siap main ranked! Cocok untuk yang ingin langsung push rank tinggi.",
                'price' => 1500000,
                'original_price' => 2000000,
                'game_server' => 'Indonesia',
                'game_level' => 'Mythic Glory',
                'status' => 'available',
                'is_featured' => true,
                'stock' => 2,
            ],
            [
                'category_id' => 1,
                'name' => 'Akun ML - 50 Skin Hero + Mythic',
                'description' => "Akun Mobile Legends dengan koleksi skin bagus!\n\n✅ 50+ Skin Hero\n✅ Rank: Mythic\n✅ Hero: 80+ hero unlock\n✅ Emblem: Level 50+\n\nCocok untuk pemain yang ingin koleksi skin tanpa harus mulai dari awal.",
                'price' => 750000,
                'original_price' => 1000000,
                'game_server' => 'Indonesia',
                'game_level' => 'Mythic',
                'status' => 'available',
                'is_featured' => true,
                'stock' => 5,
            ],
            [
                'category_id' => 2,
                'name' => 'Akun FF Max - Bundle Lengkap + Diamond Royale',
                'description' => "Akun Free Fire dengan koleksi bundle super lengkap!\n\n✅ Bundle: 30+ Bundle langka\n✅ Skin Senjata: 50+ skin\n✅ Pet: Semua pet max level\n✅ Karakter: Semua karakter unlock\n✅ Level: 75+\n\nTermasuk bundle yang sudah tidak tersedia lagi di event!",
                'price' => 500000,
                'original_price' => 750000,
                'game_server' => 'Indonesia',
                'game_level' => 'Heroic',
                'status' => 'available',
                'is_featured' => true,
                'stock' => 3,
            ],
            [
                'category_id' => 3,
                'name' => 'Akun PUBG Mobile - Conqueror + Skin Glacier M416',
                'description' => "Akun PUBG Mobile dengan rank tinggi dan skin langka!\n\n✅ Rank: Conqueror\n✅ Skin: Glacier M416, AWM, dan skin langka lainnya\n✅ Outfit: 20+ outfit premium\n✅ RP: Level Max\n\nAkun ini siap untuk competitive play!",
                'price' => 1200000,
                'original_price' => 1500000,
                'game_server' => 'Asia',
                'game_level' => 'Conqueror',
                'status' => 'available',
                'is_featured' => true,
                'stock' => 1,
            ],
            [
                'category_id' => 4,
                'name' => 'Akun Genshin - Zhongli + Raiden Shogun + Hu Tao',
                'description' => "Akun Genshin Impact dengan karakter meta!\n\n✅ Karakter 5★: Zhongli, Raiden Shogun, Hu Tao, Kazuha, Yelan\n✅ Weapon 5★: Staff of Homa, Engulfing Lightning\n✅ AR: 58\n✅ Primogems: 10.000+\n\nPerfect untuk yang ingin langsung clear Spiral Abyss!",
                'price' => 2500000,
                'original_price' => 3000000,
                'game_server' => 'Asia',
                'game_level' => 'AR 58',
                'status' => 'available',
                'is_featured' => true,
                'stock' => 2,
            ],
            [
                'category_id' => 5,
                'name' => 'Akun Valorant - Immortal 3 + Skin Bundle Premium',
                'description' => "Akun Valorant dengan rank tinggi dan skin premium!\n\n✅ Rank: Immortal 3\n✅ Skin: Champions Bundle, RGX 11z Pro, Elderflame\n✅ Agent: Semua unlock\n✅ Battlepass: 5 Battlepass completed\n\nCocok untuk yang serius bermain competitive!",
                'price' => 1800000,
                'original_price' => 2200000,
                'game_server' => 'Asia Pacific',
                'game_level' => 'Immortal 3',
                'status' => 'available',
                'is_featured' => false,
                'stock' => 4,
            ],
            [
                'category_id' => 6,
                'name' => 'Akun COC TH15 Max - Walls Max + Hero Max',
                'description' => "Akun Clash of Clans Town Hall 15 Full Max!\n\n✅ TH Level: 15 MAX\n✅ Walls: Full Max\n✅ Heroes: BK 80, AQ 80, GW 55, RC 30\n✅ Troops: Semua Max\n✅ Clan Capital: Level 8+\n\nBase kuat, siap war dan legend league!",
                'price' => 3000000,
                'original_price' => 3500000,
                'game_server' => 'Global',
                'game_level' => 'TH15 Max',
                'status' => 'available',
                'is_featured' => false,
                'stock' => 1,
            ],
            [
                'category_id' => 1,
                'name' => 'Akun ML Pemula - 30 Hero + Epic Rank',
                'description' => "Akun Mobile Legends untuk pemula!\n\n✅ 30 Hero unlock\n✅ Rank: Epic\n✅ Skin: 10 skin basic\n✅ Emblem: Level 30+\n\nCocok untuk yang baru mau mulai main ML dengan modal hero yang cukup.",
                'price' => 150000,
                'original_price' => 200000,
                'game_server' => 'Indonesia',
                'game_level' => 'Epic',
                'status' => 'available',
                'is_featured' => false,
                'stock' => 10,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Create Top Up Packages
        $topups = [
            // Mobile Legends Diamonds
            ['category_id' => 1, 'name' => '86 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 86, 'bonus_amount' => 0, 'price' => 19000, 'original_price' => 22000, 'is_popular' => false, 'sort_order' => 1],
            ['category_id' => 1, 'name' => '172 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 172, 'bonus_amount' => 0, 'price' => 38000, 'original_price' => 44000, 'is_popular' => false, 'sort_order' => 2],
            ['category_id' => 1, 'name' => '257 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 257, 'bonus_amount' => 0, 'price' => 57000, 'original_price' => 66000, 'is_popular' => false, 'sort_order' => 3],
            ['category_id' => 1, 'name' => '344 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 344, 'bonus_amount' => 0, 'price' => 76000, 'original_price' => 88000, 'is_popular' => true, 'sort_order' => 4],
            ['category_id' => 1, 'name' => '429 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 429, 'bonus_amount' => 0, 'price' => 95000, 'original_price' => 110000, 'is_popular' => false, 'sort_order' => 5],
            ['category_id' => 1, 'name' => '514 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 514, 'bonus_amount' => 0, 'price' => 114000, 'original_price' => 132000, 'is_popular' => true, 'sort_order' => 6],
            ['category_id' => 1, 'name' => '706 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 706, 'bonus_amount' => 0, 'price' => 152000, 'original_price' => 176000, 'is_popular' => false, 'sort_order' => 7],
            ['category_id' => 1, 'name' => '878 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 878, 'bonus_amount' => 0, 'price' => 190000, 'original_price' => 220000, 'is_popular' => false, 'sort_order' => 8],
            ['category_id' => 1, 'name' => '2195 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 2195, 'bonus_amount' => 0, 'price' => 475000, 'original_price' => 550000, 'is_popular' => false, 'sort_order' => 9],

            // Free Fire Diamonds
            ['category_id' => 2, 'name' => '70 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 70, 'bonus_amount' => 7, 'price' => 15000, 'original_price' => 18000, 'is_popular' => false, 'sort_order' => 1],
            ['category_id' => 2, 'name' => '140 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 140, 'bonus_amount' => 14, 'price' => 29000, 'original_price' => 35000, 'is_popular' => false, 'sort_order' => 2],
            ['category_id' => 2, 'name' => '355 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 355, 'bonus_amount' => 35, 'price' => 72000, 'original_price' => 85000, 'is_popular' => true, 'sort_order' => 3],
            ['category_id' => 2, 'name' => '720 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 720, 'bonus_amount' => 72, 'price' => 145000, 'original_price' => 170000, 'is_popular' => true, 'sort_order' => 4],
            ['category_id' => 2, 'name' => '1450 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 1450, 'bonus_amount' => 145, 'price' => 290000, 'original_price' => 340000, 'is_popular' => false, 'sort_order' => 5],
            ['category_id' => 2, 'name' => '2180 Diamonds', 'currency_name' => 'Diamonds', 'amount' => 2180, 'bonus_amount' => 218, 'price' => 435000, 'original_price' => 510000, 'is_popular' => false, 'sort_order' => 6],

            // PUBG Mobile UC
            ['category_id' => 3, 'name' => '60 UC', 'currency_name' => 'UC', 'amount' => 60, 'bonus_amount' => 0, 'price' => 15000, 'original_price' => 18000, 'is_popular' => false, 'sort_order' => 1],
            ['category_id' => 3, 'name' => '325 UC', 'currency_name' => 'UC', 'amount' => 325, 'bonus_amount' => 25, 'price' => 75000, 'original_price' => 90000, 'is_popular' => false, 'sort_order' => 2],
            ['category_id' => 3, 'name' => '660 UC', 'currency_name' => 'UC', 'amount' => 660, 'bonus_amount' => 60, 'price' => 150000, 'original_price' => 175000, 'is_popular' => true, 'sort_order' => 3],
            ['category_id' => 3, 'name' => '1800 UC', 'currency_name' => 'UC', 'amount' => 1800, 'bonus_amount' => 180, 'price' => 375000, 'original_price' => 440000, 'is_popular' => true, 'sort_order' => 4],
            ['category_id' => 3, 'name' => '3850 UC', 'currency_name' => 'UC', 'amount' => 3850, 'bonus_amount' => 500, 'price' => 750000, 'original_price' => 880000, 'is_popular' => false, 'sort_order' => 5],
            ['category_id' => 3, 'name' => '8100 UC', 'currency_name' => 'UC', 'amount' => 8100, 'bonus_amount' => 1200, 'price' => 1500000, 'original_price' => 1760000, 'is_popular' => false, 'sort_order' => 6],

            // Genshin Impact Genesis Crystals
            ['category_id' => 4, 'name' => '60 Genesis Crystals', 'currency_name' => 'Genesis Crystals', 'amount' => 60, 'bonus_amount' => 0, 'price' => 16000, 'original_price' => 19000, 'is_popular' => false, 'sort_order' => 1],
            ['category_id' => 4, 'name' => '330 Genesis Crystals', 'currency_name' => 'Genesis Crystals', 'amount' => 330, 'bonus_amount' => 30, 'price' => 79000, 'original_price' => 95000, 'is_popular' => false, 'sort_order' => 2],
            ['category_id' => 4, 'name' => '1090 Genesis Crystals', 'currency_name' => 'Genesis Crystals', 'amount' => 1090, 'bonus_amount' => 110, 'price' => 249000, 'original_price' => 300000, 'is_popular' => true, 'sort_order' => 3],
            ['category_id' => 4, 'name' => '2240 Genesis Crystals', 'currency_name' => 'Genesis Crystals', 'amount' => 2240, 'bonus_amount' => 280, 'price' => 479000, 'original_price' => 575000, 'is_popular' => true, 'sort_order' => 4],
            ['category_id' => 4, 'name' => '3880 Genesis Crystals', 'currency_name' => 'Genesis Crystals', 'amount' => 3880, 'bonus_amount' => 520, 'price' => 799000, 'original_price' => 960000, 'is_popular' => false, 'sort_order' => 5],
            ['category_id' => 4, 'name' => '8080 Genesis Crystals', 'currency_name' => 'Genesis Crystals', 'amount' => 8080, 'bonus_amount' => 1280, 'price' => 1599000, 'original_price' => 1920000, 'is_popular' => false, 'sort_order' => 6],

            // Valorant VP
            ['category_id' => 5, 'name' => '475 VP', 'currency_name' => 'VP', 'amount' => 475, 'bonus_amount' => 0, 'price' => 75000, 'original_price' => 90000, 'is_popular' => false, 'sort_order' => 1],
            ['category_id' => 5, 'name' => '1000 VP', 'currency_name' => 'VP', 'amount' => 1000, 'bonus_amount' => 50, 'price' => 150000, 'original_price' => 180000, 'is_popular' => true, 'sort_order' => 2],
            ['category_id' => 5, 'name' => '2050 VP', 'currency_name' => 'VP', 'amount' => 2050, 'bonus_amount' => 150, 'price' => 300000, 'original_price' => 360000, 'is_popular' => true, 'sort_order' => 3],
            ['category_id' => 5, 'name' => '3650 VP', 'currency_name' => 'VP', 'amount' => 3650, 'bonus_amount' => 350, 'price' => 525000, 'original_price' => 630000, 'is_popular' => false, 'sort_order' => 4],
            ['category_id' => 5, 'name' => '5350 VP', 'currency_name' => 'VP', 'amount' => 5350, 'bonus_amount' => 600, 'price' => 750000, 'original_price' => 900000, 'is_popular' => false, 'sort_order' => 5],
            ['category_id' => 5, 'name' => '11000 VP', 'currency_name' => 'VP', 'amount' => 11000, 'bonus_amount' => 1500, 'price' => 1500000, 'original_price' => 1800000, 'is_popular' => false, 'sort_order' => 6],

            // Clash of Clans Gems
            ['category_id' => 6, 'name' => '80 Gems', 'currency_name' => 'Gems', 'amount' => 80, 'bonus_amount' => 0, 'price' => 15000, 'original_price' => 18000, 'is_popular' => false, 'sort_order' => 1],
            ['category_id' => 6, 'name' => '500 Gems', 'currency_name' => 'Gems', 'amount' => 500, 'bonus_amount' => 0, 'price' => 75000, 'original_price' => 90000, 'is_popular' => false, 'sort_order' => 2],
            ['category_id' => 6, 'name' => '1200 Gems', 'currency_name' => 'Gems', 'amount' => 1200, 'bonus_amount' => 0, 'price' => 150000, 'original_price' => 180000, 'is_popular' => true, 'sort_order' => 3],
            ['category_id' => 6, 'name' => '2500 Gems', 'currency_name' => 'Gems', 'amount' => 2500, 'bonus_amount' => 0, 'price' => 299000, 'original_price' => 360000, 'is_popular' => true, 'sort_order' => 4],
            ['category_id' => 6, 'name' => '6500 Gems', 'currency_name' => 'Gems', 'amount' => 6500, 'bonus_amount' => 0, 'price' => 749000, 'original_price' => 900000, 'is_popular' => false, 'sort_order' => 5],
            ['category_id' => 6, 'name' => '14000 Gems', 'currency_name' => 'Gems', 'amount' => 14000, 'bonus_amount' => 0, 'price' => 1499000, 'original_price' => 1800000, 'is_popular' => false, 'sort_order' => 6],
        ];

        foreach ($topups as $topup) {
            TopUp::create(array_merge($topup, ['is_active' => true]));
        }
    }
}
