<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Culture;
use App\Models\EventModel;
use App\Models\Product;
use App\Models\Tourism;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. PENGGUNA
        User::firstOrCreate(['email' => 'admin@test.com'], [
            'name' => 'Administrator',
            'password' => 'password',
            'role' => 'admin'
        ]);
        User::firstOrCreate(['email' => 'buyer@test.com'], [
            'name' => 'Muhammad Dimaz',
            'password' => 'password',
            'role' => 'buyer'
        ]);
        $seller = User::firstOrCreate(['email' => 'seller@test.com'], [
            'name' => 'UMKM Kepri Jaya',
            'password' => 'password',
            'role' => 'seller'
        ]);
        $seller2 = User::firstOrCreate(['email' => 'seller2@test.com'], [
            'name' => 'Sentra Tenun & Kerajinan',
            'password' => 'password',
            'role' => 'seller'
        ]);

        // 2. KATEGORI LENGKAP
        $kuliner = Category::firstOrCreate(['slug' => 'kuliner'], ['name' => 'Kuliner', 'type' => 'product']);
        $fashion = Category::firstOrCreate(['slug' => 'fashion'], ['name' => 'Fashion', 'type' => 'product']);
        $kerajinan = Category::firstOrCreate(['slug' => 'umkm'], ['name' => 'UMKM', 'type' => 'product']);
        $souvenir = Category::firstOrCreate(['slug' => 'souvenir'], ['name' => 'Souvenir', 'type' => 'product']);

        $catTari = Category::firstOrCreate(['slug' => 'tari'], ['name' => 'Tari', 'type' => 'culture']);
        $catTradisi = Category::firstOrCreate(['slug' => 'tradisi'], ['name' => 'Tradisi', 'type' => 'culture']);
        $catKesenian = Category::firstOrCreate(['slug' => 'kesenian'], ['name' => 'Kesenian', 'type' => 'culture']);
        $catBahasa = Category::firstOrCreate(['slug' => 'bahasa'], ['name' => 'Bahasa', 'type' => 'culture']);

        $catSejarah = Category::firstOrCreate(['slug' => 'sejarah'], ['name' => 'Wisata Sejarah', 'type' => 'tourism']);
        $catPantai = Category::firstOrCreate(['slug' => 'pantai'], ['name' => 'Pantai', 'type' => 'tourism']);
        $catKeluarga = Category::firstOrCreate(['slug' => 'keluarga'], ['name' => 'Wisata Keluarga', 'type' => 'tourism']);

        // 3. DATA UMKM
        $umkm1 = Umkm::firstOrCreate(['slug' => 'otak-otak-shalsabyla'], [
            'user_id' => $seller->id,
            'name' => 'Otak Otak Shalsabyla',
            'description' => 'Pusat kuliner tradisional khas pesisir dengan olahan siput gonggong dan ikan segar.',
            'address' => 'Jl. Pos No. 18, Tanjungpinang',
            'phone' => '081277889900',
            'email' => 'shalsabyla@umkm.id',
            'latitude' => 0.9165,
            'longitude' => 104.4460,
            'status' => 'approved',
        ]);

        $umkm2 = Umkm::firstOrCreate(['slug' => 'tenun-khatulistiwa-melayu'], [
            'user_id' => $seller2->id,
            'name' => 'Tenun Khatulistiwa Melayu',
            'description' => 'Pelestari kain tenun songket dan kerajinan anyaman tradisional Kepulauan Riau.',
            'address' => 'Jl. Merdeka No. 42, Tanjungpinang',
            'phone' => '081366554433',
            'email' => 'tenun@khatulistiwa.id',
            'latitude' => 0.9150,
            'longitude' => 104.4480,
            'status' => 'approved',
        ]);

        // 4. PRODUK SESUAI FIGMA
        Product::updateOrCreate(['slug' => 'kain-tenun-melayu'], [
            'umkm_id' => $umkm2->id,
            'category_id' => $fashion->id,
            'name' => 'Kain Tenun Melayu',
            'description' => 'Kain tenun corak tradisional Melayu berkualitas tinggi dengan benang emas asli.',
            'price' => 80000,
            'stock' => 50,
            'image' => '/storage/catalog/kain-tenun-melayu.jpg',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Product::updateOrCreate(['slug' => 'gonggong-olahan'], [
            'umkm_id' => $umkm1->id,
            'category_id' => $kuliner->id,
            'name' => 'Gonggong Olahan',
            'description' => 'Siput gonggong segar bumbu rempah pilihan khas kuliner Tanjungpinang.',
            'price' => 60000,
            'stock' => 100,
            'image' => '/storage/catalog/gonggong-olahan.jpg',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Product::updateOrCreate(['slug' => 'tas-anyaman'], [
            'umkm_id' => $umkm2->id,
            'category_id' => $kerajinan->id,
            'name' => 'Tas Anyaman',
            'description' => 'Tas jinjing etnik hasil anyaman pandan laut ramah lingkungan.',
            'price' => 75000,
            'stock' => 60,
            'image' => '/storage/catalog/tas-anyaman.jpg',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Product::updateOrCreate(['slug' => 'miniatur-kapal'], [
            'umkm_id' => $umkm2->id,
            'category_id' => $souvenir->id,
            'name' => 'Miniatur Kapal',
            'description' => 'Karya kerajinan kayu replika kapal pinisi maritim Melayu yang detail dan mewah.',
            'price' => 250000,
            'stock' => 25,
            'image' => '/storage/catalog/miniatur-kapal.jpg',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Product::updateOrCreate(['slug' => 'batik'], [
            'umkm_id' => $umkm2->id,
            'category_id' => $fashion->id,
            'name' => 'Batik',
            'description' => 'Kain batik motif tabur gonggong dan pucuk rebung khas Kota Gurindam.',
            'price' => 99000,
            'stock' => 80,
            'image' => '/storage/catalog/batik.jpg',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Product::updateOrCreate(['slug' => 'luti-gendang'], [
            'umkm_id' => $umkm1->id,
            'category_id' => $kuliner->id,
            'name' => 'Luti Gendang',
            'description' => 'Roti goreng renyah isi abon ikan tongkol gurih legit khas Kepulauan Riau.',
            'price' => 20000,
            'stock' => 150,
            'image' => '/storage/catalog/luti-gendang.jpg',
            'is_featured' => true,
            'status' => 'active',
        ]);

        // 5. BUDAYA
        Culture::updateOrCreate(['slug' => 'tari-zapin'], [
            'category_id' => $catTari->id,
            'name' => 'Tari Zapin',
            'short_description' => 'Tarian tradisional khas Masyarakat Melayu yang sarat nilai edukasi dan agama.',
            'description' => 'Tari Zapin merupakan tarian rumpun Melayu yang sarat dengan gerakan kaki dinamis diiringi gambus dan marwas.',
            'location' => 'Kota Tanjungpinang',
            'latitude' => 0.9174,
            'longitude' => 104.4501,
            'image' => '/storage/catalog/tari-zapin.jpg',
            'is_featured' => true,
        ]);

        Culture::updateOrCreate(['slug' => 'kain-tenun-songket'], [
            'category_id' => $catKesenian->id,
            'name' => 'Kain Tenun Songket Melayu',
            'short_description' => 'Seni menenun benang sutra dan emas warisan leluhur Riau-Lingga.',
            'description' => 'Kain tenun songket khas Melayu Tanjungpinang memiliki ragam hias flora dan fauna maritim yang ditenun secara tradisional.',
            'location' => 'Kampung Bugis, Tanjungpinang',
            'latitude' => 0.9320,
            'longitude' => 104.4410,
            'image' => '/storage/catalog/kain-tenun-melayu.jpg',
            'is_featured' => true,
        ]);

        Culture::updateOrCreate(['slug' => 'gurindam-dua-belas'], [
            'category_id' => $catBahasa->id,
            'name' => 'Inilah Gurindam Dua Belas',
            'short_description' => 'Karya sastra legendaris Raja Ali Haji di Pulau Penyengat.',
            'description' => 'Karya sastra puisi didaktik pasal demi pasal yang menjadi pedoman akhlak dan budi pekerti bangsa Melayu.',
            'location' => 'Pulau Penyengat',
            'latitude' => 0.9250,
            'longitude' => 104.4230,
            'image' => '/storage/catalog/gurindam.jpg',
            'is_featured' => true,
        ]);

        Culture::updateOrCreate(['slug' => 'musik-kompang-dan-marwas'], [
            'category_id' => $catTradisi->id,
            'name' => 'Alat Musik Tradisional Kompang',
            'short_description' => 'Gendang rebana khas Melayu pengiring arak-arakan pengantin dan upacara adat.',
            'description' => 'Kompang adalah alat musik tabuh dari kulit kambing yang dimainkan bersama-sama dalam irama rancak menyemarakkan acara adat.',
            'location' => 'Senggarang, Tanjungpinang',
            'latitude' => 0.9410,
            'longitude' => 104.4480,
            'image' => '/storage/catalog/kompang.jpg',
            'is_featured' => true,
        ]);

        // 6. WISATA SESUAI FIGMA
        Tourism::updateOrCreate(['slug' => 'masjid-raya-sultan-riau'], [
            'category_id' => $catSejarah->id,
            'name' => 'Masjid Raya Sultan Riau Penyengat',
            'short_description' => 'Masjid bersejarah berkubah kuning yang dibangun menggunakan perekat putih telur.',
            'description' => 'Salah satu masjid tertua di Kepulauan Riau yang dibangun pada tahun 1832 dan menyimpan mushaf Al-Qur\'an tulis tangan bersejarah.',
            'location' => 'Pulau Penyengat, Tanjungpinang',
            'latitude' => 0.9255,
            'longitude' => 104.4215,
            'ticket_price' => 0,
            'open_time' => '05:00:00',
            'close_time' => '21:00:00',
            'image' => '/storage/catalog/masjid-penyengat.jpg',
            'is_featured' => true,
        ]);

        Tourism::updateOrCreate(['slug' => 'vihara-ksitigarbha-bodhisattva'], [
            'category_id' => $catKeluarga->id,
            'name' => 'Vihara Ksitigarbha Bodhisattva (500 Lohan)',
            'short_description' => 'Destinasi religi megah dengan ratusan patung batu berwajah unik.',
            'description' => 'Vihara terkenal dengan 500 patung Arahat berukuran manusia dengan ekspresi berbeda-beda yang dipahat dari batu granit.',
            'location' => 'Batu 13, Tanjungpinang',
            'latitude' => 0.9110,
            'longitude' => 104.4980,
            'ticket_price' => 10000,
            'open_time' => '08:00:00',
            'close_time' => '17:00:00',
            'image' => '/storage/catalog/masjid-penyengat.jpg',
            'is_featured' => true,
        ]);

        Tourism::updateOrCreate(['slug' => 'kawasan-tepi-laut-sunset'], [
            'category_id' => $catPantai->id,
            'name' => 'Kawasan Tepi Laut Sunset',
            'short_description' => 'Spot terbaik menikmati matahari terbenam dengan hembusan angin Selat Riau.',
            'description' => 'Ruang publik terbuka di sepanjang pesisir Tanjungpinang tempat warga berkumpul bersantai menikmati senja.',
            'location' => 'Laman Boenda, Tanjungpinang',
            'latitude' => 0.9160,
            'longitude' => 104.4450,
            'ticket_price' => 0,
            'open_time' => '00:00:00',
            'close_time' => '23:59:00',
            'image' => '/storage/catalog/tepi-laut.jpg',
            'is_featured' => true,
        ]);

        Tourism::updateOrCreate(['slug' => 'pasar-malam-kuliner-akau-potong-lembu'], [
            'category_id' => $catKeluarga->id,
            'name' => 'Pusat Kuliner Akau Potong Lembu',
            'short_description' => 'Pusat wisata kuliner legendaris malam hari di Tanjungpinang.',
            'description' => 'Pasar malam legendaris dengan deretan lampion dan tenda warna-warni yang menjajakan aneka makanan khas Melayu dan Tionghoa.',
            'location' => 'Potong Lembu, Tanjungpinang',
            'latitude' => 0.9180,
            'longitude' => 104.4520,
            'ticket_price' => 0,
            'open_time' => '17:00:00',
            'close_time' => '23:30:00',
            'image' => '/storage/catalog/akau.jpg',
            'is_featured' => true,
        ]);

        // 7. EVENT
        EventModel::updateOrCreate(['slug' => 'festival-budaya-melayu'], [
            'name' => 'Festival Budaya Melayu',
            'description' => 'Parade akbar tari zapin, lomba berbalas pantun, dan karnaval busana adat khas Melayu.',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(8),
            'location' => 'Laman Boenda, Tepi Laut',
            'latitude' => 0.9160,
            'longitude' => 104.4450,
            'is_registration_open' => true,
            'max_participants' => 500,
            'status' => 'upcoming',
            'image' => '/storage/catalog/tari-zapin.jpg',
        ]);

        EventModel::updateOrCreate(['slug' => 'pameran-umkm-lokal'], [
            'name' => 'Pameran UMKM Lokal',
            'description' => 'Bazar puluhan stan produk kuliner tradisional, kriya anyaman, dan busana batik khas Kepri.',
            'start_date' => now()->addDays(10),
            'end_date' => now()->addDays(14),
            'location' => 'Gedung Gonggong, Tanjungpinang',
            'latitude' => 0.9174,
            'longitude' => 104.4501,
            'is_registration_open' => true,
            'max_participants' => 300,
            'status' => 'upcoming',
            'image' => '/storage/catalog/akau.jpg',
        ]);

        EventModel::updateOrCreate(['slug' => 'pertunjukan-tari-zapin'], [
            'name' => 'Pertunjukan Tari Zapin',
            'description' => 'Malam pentas seni gerak ritmis persembahan para maestro tari Melayu Kepulauan Riau.',
            'start_date' => now()->addDays(16),
            'end_date' => now()->addDays(17),
            'location' => 'Balai Adat Pulau Penyengat',
            'latitude' => 0.9250,
            'longitude' => 104.4230,
            'is_registration_open' => true,
            'max_participants' => 200,
            'status' => 'upcoming',
            'image' => '/storage/catalog/event-budaya.jpg',
        ]);

        EventModel::updateOrCreate(['slug' => 'workshop-tenun-melayu'], [
            'name' => 'Workshop Tenun Melayu',
            'description' => 'Pelatihan intensif teknik menenun benang pakan dan lungsi bagi generasi muda pemula.',
            'start_date' => now()->addDays(22),
            'end_date' => now()->addDays(24),
            'location' => 'Pusat Kriya Tenun Tanjungpinang',
            'latitude' => 0.9200,
            'longitude' => 104.4600,
            'is_registration_open' => true,
            'max_participants' => 50,
            'status' => 'upcoming',
            'image' => '/storage/catalog/workshop.jpg',
        ]);

        // 8. DATA ULASAN AWAL (SESUAI DESAIN FIGMA)
        $buyer = User::where('email', 'buyer@test.com')->first();
        $buyer2 = User::firstOrCreate(['email' => 'dimaz.bintani@test.com'], [
            'name' => 'Muhammad Dimaz Al Bintani',
            'password' => 'password',
            'role' => 'buyer'
        ]);

        $sampleProduct = Product::where('slug', 'gonggong-olahan')->first() ?? Product::first();

        if ($buyer2 && $sampleProduct) {
            $sampleOrder = \App\Models\Order::firstOrCreate(['order_number' => 'ORD-REV001'], [
                'user_id' => $buyer2->id,
                'subtotal' => 60000,
                'shipping_cost' => 0,
                'total' => 60000,
                'shipping_name' => 'Muhammad Dimaz Al Bintani',
                'shipping_phone' => '081234567890',
                'shipping_address' => 'Tanjungpinang',
                'status' => 'completed',
            ]);

            \App\Models\Review::updateOrCreate(
                ['user_id' => $buyer2->id, 'product_id' => $sampleProduct->id],
                [
                    'order_id' => $sampleOrder->id,
                    'rating' => 4,
                    'comment' => 'Otak otaknya enak banget! Sesuai ekspektasi, tapi gabisa bintang 5 karna mahal banget..',
                    'created_at' => now()->subDays(26),
                ]
            );

            $buyer3 = User::firstOrCreate(['email' => 'dimaz.repeat@test.com'], [
                'name' => 'Muhammad Dimaz Al Bintani',
                'password' => 'password',
                'role' => 'buyer'
            ]);
            $sampleOrder2 = \App\Models\Order::firstOrCreate(['order_number' => 'ORD-REV002'], [
                'user_id' => $buyer3->id,
                'subtotal' => 60000,
                'shipping_cost' => 0,
                'total' => 60000,
                'shipping_name' => 'Muhammad Dimaz Al Bintani',
                'shipping_phone' => '081234567890',
                'shipping_address' => 'Tanjungpinang',
                'status' => 'completed',
            ]);
            \App\Models\Review::updateOrCreate(
                ['user_id' => $buyer3->id, 'product_id' => $sampleProduct->id],
                [
                    'order_id' => $sampleOrder2->id,
                    'rating' => 5,
                    'comment' => 'Udah beli lagi, harganya udah turun coy! Jadi Bintang 5 buat penjual dan platform nya!',
                    'created_at' => now()->subDays(21),
                ]
            );

            $buyer4 = User::firstOrCreate(['email' => 'dimaz.promo@test.com'], [
                'name' => 'Muhammad Dimaz Al Bintani',
                'password' => 'password',
                'role' => 'buyer'
            ]);
            $sampleOrder3 = \App\Models\Order::firstOrCreate(['order_number' => 'ORD-REV003'], [
                'user_id' => $buyer4->id,
                'subtotal' => 60000,
                'shipping_cost' => 0,
                'total' => 60000,
                'shipping_name' => 'Muhammad Dimaz Al Bintani',
                'shipping_phone' => '081234567890',
                'shipping_address' => 'Tanjungpinang',
                'status' => 'completed',
            ]);
            \App\Models\Review::updateOrCreate(
                ['user_id' => $buyer4->id, 'product_id' => $sampleProduct->id],
                [
                    'order_id' => $sampleOrder3->id,
                    'rating' => 3,
                    'comment' => 'Ternyata kemaren cuma diskon hmm',
                    'created_at' => now()->subDays(14),
                ]
            );

            $buyer5 = User::firstOrCreate(['email' => 'dimaz.top@test.com'], [
                'name' => 'Muhammad Dimaz Al Bintani',
                'password' => 'password',
                'role' => 'buyer'
            ]);
            $sampleOrder4 = \App\Models\Order::firstOrCreate(['order_number' => 'ORD-REV004'], [
                'user_id' => $buyer5->id,
                'subtotal' => 60000,
                'shipping_cost' => 0,
                'total' => 60000,
                'shipping_name' => 'Muhammad Dimaz Al Bintani',
                'shipping_phone' => '081234567890',
                'shipping_address' => 'Tanjungpinang',
                'status' => 'completed',
            ]);
            \App\Models\Review::updateOrCreate(
                ['user_id' => $buyer5->id, 'product_id' => $sampleProduct->id],
                [
                    'order_id' => $sampleOrder4->id,
                    'rating' => 5,
                    'comment' => 'Keren',
                    'created_at' => now()->subDays(11),
                ]
            );
        }
    }
}
