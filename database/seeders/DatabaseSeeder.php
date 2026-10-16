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
        User::firstOrCreate(['email' => 'admin@test.com'], ['name' => 'Administrator', 'password' => 'password', 'role' => 'admin']);
        User::firstOrCreate(['email' => 'buyer@test.com'], ['name' => 'Pembeli Umum', 'password' => 'password', 'role' => 'buyer']);
        $seller = User::firstOrCreate(['email' => 'seller@test.com'], ['name' => 'UMKM Kepri Jaya', 'password' => 'password', 'role' => 'seller']);
        $seller2 = User::firstOrCreate(['email' => 'seller2@test.com'], ['name' => 'Batik Gonggong Melayu', 'password' => 'password', 'role' => 'seller']);

        $kuliner = Category::firstOrCreate(['slug' => 'kuliner-makanan'], ['name' => 'Kuliner & Makanan', 'type' => 'product']);
        Category::firstOrCreate(['slug' => 'kerajinan-tangan'], ['name' => 'Kerajinan Tangan', 'type' => 'product']);
        $batik = Category::firstOrCreate(['slug' => 'pakaian-batik'], ['name' => 'Pakaian & Batik', 'type' => 'product']);
        $seni = Category::firstOrCreate(['slug' => 'seni-tradisi'], ['name' => 'Seni & Tradisi', 'type' => 'culture']);
        $bahari = Category::firstOrCreate(['slug' => 'bahari-alam'], ['name' => 'Bahari & Alam', 'type' => 'tourism']);

        $umkm1 = Umkm::firstOrCreate(['slug' => 'kerupuk-atom-mak-ngah'], [
            'user_id' => $seller->id,
            'name' => 'Kerupuk Atom Mak Ngah',
            'description' => 'Produsen kerupuk ikan khas Tanjungpinang sejak tahun 1995 dengan rasa ikan segar pilihan.',
            'address' => 'Jl. Ir. H. Juanda No. 45, Tanjungpinang',
            'phone' => '081277889900',
            'email' => 'makngah@umkm.id',
            'latitude' => 0.9174,
            'longitude' => 104.4501,
            'status' => 'approved',
        ]);

        $umkm2 = Umkm::firstOrCreate(['slug' => 'batik-gonggong-melayu'], [
            'user_id' => $seller2->id,
            'name' => 'Batik Gonggong Melayu',
            'description' => 'Pusat pembuatan kain batik tulis dan cap dengan motif khas siput gonggong Tanjungpinang.',
            'address' => 'Jl. Merdeka No. 12, Tanjungpinang',
            'phone' => '081366554433',
            'email' => 'gonggong@batik.id',
            'latitude' => 0.9150,
            'longitude' => 104.4480,
            'status' => 'approved',
        ]);

        Product::firstOrCreate(['slug' => 'kerupuk-ikan-gonggong-asli'], [
            'umkm_id' => $umkm1->id,
            'category_id' => $kuliner->id,
            'name' => 'Kerupuk Ikan Gonggong Asli',
            'slug' => 'kerupuk-ikan-gonggong-asli',
            'description' => 'Kerupuk renyah dengan campuran daging siput gonggong khas kepulauan Riau.',
            'price' => 35000,
            'stock' => 150,
            'image' => 'https://images.unsplash.com/photo-1599487488170-ded1ec92642f?auto=format&fit=crop&w=500&q=80',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Product::firstOrCreate(['slug' => 'otak-otak-ikan-tenggiri'], [
            'umkm_id' => $umkm1->id,
            'category_id' => $kuliner->id,
            'name' => 'Otak-Otak Ikan Tenggiri',
            'description' => 'Otak-otak segar dibungkus daun kelapa dengan bumbu rempah khas Melayu.',
            'price' => 2500,
            'stock' => 300,
            'image' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?auto=format&fit=crop&w=500&q=80',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Product::firstOrCreate(['slug' => 'kain-batik-motif-gonggong'], [
            'umkm_id' => $umkm2->id,
            'category_id' => $batik->id,
            'name' => 'Kain Batik Motif Gonggong Eksklusif',
            'description' => 'Kain batik katun premium dengan corak flora dan fauna laut khas Tanjungpinang.',
            'price' => 250000,
            'stock' => 45,
            'image' => 'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?auto=format&fit=crop&w=500&q=80',
            'is_featured' => true,
            'status' => 'active',
        ]);

        Culture::firstOrCreate(['slug' => 'gurindam-dua-belas'], [
            'category_id' => $seni->id,
            'name' => 'Gurindam Dua Belas',
            'short_description' => 'Mahakarya sastra klasik buatan Raja Ali Haji.',
            'description' => 'Gurindam Dua Belas adalah warisan sastra Melayu yang sangat terkenal di Kepulauan Riau dan Nusantara, berisi nasihat agama dan moral.',
            'history' => 'Ditulis oleh Raja Ali Haji di Pulau Penyengat pada tahun 1847.',
            'location' => 'Pulau Penyengat, Tanjungpinang',
            'latitude' => 0.9250,
            'longitude' => 104.4230,
            'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
        ]);

        Culture::firstOrCreate(['slug' => 'tari-persembahan-melayu'], [
            'category_id' => $seni->id,
            'name' => 'Tari Persembahan Melayu',
            'short_description' => 'Tarian penyambutan tamu agung khas adat Melayu.',
            'description' => 'Tari Persembahan atau Tari Zapin dan Mak Inang disajikan untuk menyambut tamu terhormat dalam acara adat dan kenegaraan.',
            'history' => 'Berkembang sejak masa Kesultanan Lingga-Riau.',
            'location' => 'Kota Tanjungpinang',
            'latitude' => 0.9174,
            'longitude' => 104.4501,
            'image' => 'https://images.unsplash.com/photo-1508700115892-45ecd05ae2ad?auto=format&fit=crop&w=800&q=80',
            'is_featured' => true,
        ]);

        Tourism::firstOrCreate(['slug' => 'pulau-penyengat-inderasakti'], [
            'category_id' => $bahari->id,
            'name' => 'Pulau Penyengat Inderasakti',
            'short_description' => 'Pulau bersejarah pusat Kesultanan Riau-Lingga.',
            'description' => 'Pulau bersejarah yang menyimpan Masjid Raya Sultan Riau yang terbuat dari putih telur, makam raja-raja, dan benteng pertahanan.',
            'location' => 'Pulau Penyengat, Tanjungpinang',
            'latitude' => 0.9250,
            'longitude' => 104.4230,
            'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=80',
            'ticket_price' => 10000,
            'open_time' => '07:00:00',
            'close_time' => '18:00:00',
            'is_featured' => true,
        ]);

        Tourism::firstOrCreate(['slug' => 'tepi-laut-tanjungpinang'], [
            'category_id' => $bahari->id,
            'name' => 'Tepi Laut Tanjungpinang (Laman Boenda)',
            'short_description' => 'Kawasan waterfront city ikonik menikmati sunset.',
            'description' => 'Pusat keramaian di tepi laut yang menawarkan pemandangan Selat Bintan, kuliner lokal, dan Gonggong Monument.',
            'location' => 'Tepi Laut, Tanjungpinang',
            'latitude' => 0.9160,
            'longitude' => 104.4450,
            'image' => 'https://images.unsplash.com/photo-1519046904884-53103b34b206?auto=format&fit=crop&w=800&q=80',
            'ticket_price' => 0,
            'open_time' => '00:00:00',
            'close_time' => '23:59:00',
            'is_featured' => true,
        ]);

        EventModel::firstOrCreate(['slug' => 'festival-pulau-penyengat-2026'], [
            'name' => 'Festival Pulau Penyengat 2026',
            'description' => 'Pameran budaya, lomba berbalas pantun, pameran kuliner tempo dulu, dan napak tilas sejarah.',
            'start_date' => now()->addDays(20),
            'end_date' => now()->addDays(23),
            'location' => 'Pulau Penyengat',
            'latitude' => 0.9250,
            'longitude' => 104.4230,
            'is_registration_open' => true,
            'max_participants' => 1000,
            'status' => 'upcoming',
        ]);
    }
}
