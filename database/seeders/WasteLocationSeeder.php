<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WasteLocation;

class WasteLocationSeeder extends Seeder
{
    public function run()
    {
       $locations = [
            // TPA
        [
            'name' => 'Gampong Jawa',
            'type' => 'TPA',
            'address' => 'H8H8+F84, Gampong Jawa, Kec. Kuta Raja, Kota Banda Aceh, Aceh 24415',
            'latitude' => '5.578873188838176',
            'longitude' => '95.31584652418448',
            'capacity' => 100.00,
            'contact_number' => '081234567890',
        ],
        [
            'name' => 'Jl. Proklamasi No.28',
            'type' => 'TPA',
            'address' => 'Jl. Proklamasi No.28, Manggar, Kec. Balikpapan Tim., Kota Balikpapan, Kalimantan Timur 76117',
            'latitude' => '-1.212900893417675',
            'longitude' => '116.93858284163593',
            'capacity' => 120.00,
            'contact_number' => '081234567891',
        ],
        [
            'name' => 'Jl. Proklamasi No.28 (Alternate)',
            'type' => 'TPA',
            'address' => 'Jl. Proklamasi No.28, Manggar, Kec. Balikpapan Tim., Kota Balikpapan, Kalimantan Timur 76117',
            'latitude' => '-1.2130188841668368',
            'longitude' => '116.93850773978501',
            'capacity' => 110.00,
            'contact_number' => '081234567892',
        ],
        [
            'name' => 'Bukit Pinang',
            'type' => 'TPA',
            'address' => 'G4V8+4FP, Bukit Pinang, Kec. Samarinda Ulu, Kota Samarinda, Kalimantan Timur 75131',
            'latitude' => '-0.4570892000776652',
            'longitude' => '117.11623191067012',
            'capacity' => 130.00,
            'contact_number' => '081234567893',
        ],
        [
            'name' => 'Dusun I, Wlahar Wetan',
            'type' => 'TPA',
            'address' => 'G75H+GWM, Dusun I, Wlahar Wetan, Kec. Kalibagor, Kabupaten Banyumas, Jawa Tengah',
            'latitude' => '-7.490961647173898',
            'longitude' => '109.2797002646794',
            'capacity' => 140.00,
            'contact_number' => '081234567894',
        ],

            // TPS
        [
            'name' => 'Rappokalling',
            'type' => 'TPS',
            'address' => 'Jl. AR Dg. Ngunjung No.3, Rappokalling, Kec. Tallo, Kota Makassar, Sulawesi Selatan 90215',
            'latitude' => '-5.123429647056506',
            'longitude' => '119.43881571437187',
            'capacity' => 50.00,
            'contact_number' => '081234567895',
        ],
        [
            'name' => 'Perum. Kafa Aqila',
            'type' => 'TPS',
            'address' => 'Jl. Transpol No.28, Sungai Tiung, Kec. Cemp., Kota Banjar Baru, Kalimantan Selatan 70333',
            'latitude' => '-3.5052317825400436',
            'longitude' => '114.85646718184273',
            'capacity' => 60.00,
            'contact_number' => '081234567896',
        ],
        [
            'name' => 'Rawajati Timur',
            'type' => 'TPS',
            'address' => 'Jl. Rawajati Timur II No.69 4, RT.4/RW.6, Rawajati, Kec. Pancoran, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12750',
            'latitude' => '-6.2627110920230145',
            'longitude' => '106.85390776466747',
            'capacity' => 70.00,
            'contact_number' => '081234567897',
        ],
        [
            'name' => 'Gebang Putih',
            'type' => 'TPS',
            'address' => 'PQ8P+65R, Gebang Putih, Kec. Sukolilo, Surabaya, Jawa Timur 60117',
            'latitude' => '-7.284317739255117',
            'longitude' => '112.78542858187151',
            'capacity' => 80.00,
            'contact_number' => '081234567898',
        ],
        [
            'name' => 'Gandasuli',
            'type' => 'TPS',
            'address' => 'H66Q+M59, Gandasuli, Karangpucung, Kec. Purwokerto Sel., Kabupaten Banyumas, Jawa Tengah 53142',
            'latitude' => '-7.438221138362852',
            'longitude' => '109.2378245665297',
            'capacity' => 90.00,
            'contact_number' => '081234567899',
        ],
    ];

    DB::table('waste_locations')->insert($locations);
}
}
}
