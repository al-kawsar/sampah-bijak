<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LearningModuleSeeder extends Seeder
{
    public function run()
    {
        $learningModules = [
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Pengelolaan Sampah Rumah Tangga',
                'description' => 'Panduan praktis untuk mengelola sampah rumah tangga dengan bijak.',
                'content' => '
                <h2>Pengenalan</h2>
                <p>Sampah rumah tangga adalah salah satu penyumbang utama limbah di berbagai daerah. Sebagian besar sampah ini berakhir di tempat pembuangan akhir (TPA), yang dapat menyebabkan berbagai masalah lingkungan, seperti pencemaran tanah, air, dan udara. Namun, dengan pengelolaan yang baik, kita dapat mengurangi dampak negatifnya terhadap lingkungan sekaligus meningkatkan kualitas hidup masyarakat.</p>
                <p>Pengelolaan sampah yang efektif bukan hanya tanggung jawab pemerintah, tetapi juga setiap individu. Langkah kecil yang dilakukan di rumah dapat memberikan dampak besar jika diterapkan secara kolektif oleh banyak orang.</p>

                <h3>Langkah-Langkah Pengelolaan Sampah</h3>
                <ol>
                <li><b>Pilah Sampah:</b>
                <p>Langkah pertama dan paling penting adalah memisahkan sampah berdasarkan jenisnya. Berikut kategori utama:</p>
                <ul>
                <li><b>Organik:</b> Sisa makanan, kulit buah, daun kering, dan bahan alami lainnya yang dapat terurai.</li>
                <li><b>Anorganik:</b> Plastik, kertas, logam, dan bahan lain yang bisa didaur ulang.</li>
                <li><b>B3 (Bahan Berbahaya dan Beracun):</b> Limbah seperti baterai bekas, lampu neon, dan bahan kimia rumah tangga.</li>
                </ul>
                <p>Dengan memilah sampah, kita mempermudah proses daur ulang dan mengurangi volume sampah yang harus diangkut ke TPA.</p>
                </li>
                <li><b>Gunakan Bank Sampah:</b>
                <p>Bank sampah adalah tempat di mana sampah anorganik yang dapat didaur ulang dikumpulkan, diproses, dan dijual kembali. Anda bisa bergabung dengan bank sampah di komunitas Anda atau memulai sendiri di lingkungan tempat tinggal.</p>
                </li>
                <li><b>Kompos:</b>
                <p>Mengubah sampah organik menjadi pupuk kompos adalah cara yang efektif untuk mengurangi limbah. Anda dapat membuat kompos di rumah menggunakan metode sederhana seperti komposter ember atau keranjang. Kompos ini bisa digunakan untuk menyuburkan tanaman di taman atau pot rumah Anda.</p>
                </li>
                <li><b>Kurangi Sampah Plastik:</b>
                <p>Plastik adalah salah satu jenis sampah yang paling sulit terurai. Beberapa cara untuk menguranginya adalah:</p>
                <ul>
                <li>Gunakan tas belanja kain daripada kantong plastik sekali pakai.</li>
                <li>Bawa botol minum sendiri untuk mengurangi penggunaan botol plastik sekali pakai.</li>
                <li>Pilih produk dengan kemasan minimal atau kemasan yang dapat didaur ulang.</li>
                </ul>
                </li>
                </ol>

                <h3>Manfaat Pengelolaan Sampah yang Baik</h3>
                <p>Melakukan pengelolaan sampah secara konsisten memberikan banyak manfaat, antara lain:</p>
                <ul>
                <li><b>Mengurangi Polusi Lingkungan:</b> Sampah yang dikelola dengan baik tidak akan mencemari tanah, air, atau udara.</li>
                <li><b>Meminimalkan Penggunaan TPA:</b> Dengan memilah dan mendaur ulang sampah, volume sampah yang dikirim ke TPA dapat dikurangi secara signifikan.</li>
                <li><b>Mendukung Ekonomi Sirkular:</b> Sampah yang didaur ulang menciptakan peluang ekonomi baru, seperti pekerjaan di sektor daur ulang dan produksi barang ramah lingkungan.</li>
                <li><b>Menjaga Kesehatan Masyarakat:</b> Lingkungan yang bersih mengurangi risiko penyebaran penyakit akibat sampah yang tidak terkelola.</li>
                <li><b>Meningkatkan Kesadaran Lingkungan:</b> Melalui pengelolaan sampah, kita dapat mendidik generasi muda tentang pentingnya menjaga bumi.</li>
                </ul>
                <p>Mulailah dari langkah kecil di rumah Anda. Ingat, perubahan besar selalu dimulai dari hal-hal sederhana yang dilakukan secara konsisten!</p>
                ',
                'thumbnail' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Daur Ulang Sampah Plastik',
                'description' => 'Pelajari cara mendaur ulang sampah plastik untuk membantu keberlanjutan lingkungan.',
                'content' => '
                <h2>Mengapa Daur Ulang Plastik Penting?</h2>
                <p>Plastik membutuhkan ratusan tahun untuk terurai. Dengan mendaur ulang, kita bisa mengurangi sampah yang menumpuk di TPA.</p>
                <h3>Cara Mendaur Ulang Sampah Plastik</h3>
                <ul>
                <li>Cuci bersih botol plastik sebelum mendaur ulang.</li>
                <li>Pisahkan berdasarkan jenis plastik (PET, HDPE, dll).</li>
                <li>Kirim plastik ke tempat daur ulang atau bank sampah.</li>
                </ul>
                <p>Daur ulang plastik tidak hanya mengurangi limbah, tetapi juga mendukung ekonomi sirkular.</p>
                ',
                'thumbnail' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => \Illuminate\Support\Str::uuid(),
                'title' => 'Komunitas Peduli Sampah',
                'description' => 'Cara membangun komunitas yang peduli terhadap pengelolaan sampah.',
                'content' => '
                <h2>Membangun Komunitas</h2>
                <p>Komunitas memiliki peran penting sebagai agen perubahan dalam pengelolaan sampah. Dengan melibatkan berbagai elemen masyarakat, langkah-langkah kolaboratif dapat dilakukan untuk menciptakan lingkungan yang lebih bersih dan sehat. Setiap anggota komunitas memiliki kontribusi yang berharga dalam menciptakan perubahan positif.</p>

                <p>Langkah pertama adalah mengidentifikasi masalah utama yang ada di lingkungan Anda. Masalah ini bisa berupa kurangnya tempat pembuangan sampah, minimnya fasilitas daur ulang, atau rendahnya kesadaran masyarakat. Dengan memahami akar permasalahan, komunitas dapat menentukan prioritas yang perlu ditangani untuk memulai program yang efektif dan berdampak nyata.</p>

                <p>Setelah memahami masalah, langkah berikutnya adalah mengajukan solusi yang tepat. Edukasi masyarakat melalui berbagai metode, seperti seminar, diskusi kelompok, atau kampanye media sosial, dapat membantu meningkatkan kesadaran dan memberikan informasi tentang pentingnya pengelolaan sampah. Pengetahuan ini akan menjadi dasar untuk mendorong perilaku yang lebih bertanggung jawab terhadap lingkungan.</p>

                <p>Kegiatan yang melibatkan masyarakat secara langsung sangat penting untuk menciptakan dampak nyata. Beberapa kegiatan yang dapat dilakukan meliputi:</p>
                <ul>
                <li>Gotong-royong membersihkan lingkungan sekitar untuk membangun kebersamaan dan tanggung jawab kolektif.</li>
                <li>Pelatihan daur ulang untuk menciptakan produk bernilai ekonomi, seperti kerajinan dari plastik bekas atau kompos dari sampah organik.</li>
                <li>Pendirian bank sampah yang memberikan insentif finansial untuk memilah sampah rumah tangga.</li>
                <li>Penanaman pohon di lahan kosong sebagai bentuk penghijauan dan pengelolaan lingkungan yang lebih baik.</li>
                </ul>

                <p>Membangun kemitraan dengan berbagai pihak adalah langkah strategis untuk memastikan keberlanjutan program. Sekolah dapat dilibatkan untuk mendidik generasi muda tentang pentingnya menjaga lingkungan. Pemerintah setempat dapat menyediakan dukungan fasilitas seperti tempat sampah terpilah dan pengangkutan sampah secara teratur. Organisasi non-profit atau perusahaan swasta dapat membantu dengan pendanaan atau pelatihan teknis yang diperlukan untuk menjalankan program.</p>

                <p>Salah satu aspek penting lainnya adalah membangun komunikasi yang efektif dalam komunitas. Diskusi terbuka dan transparansi akan menciptakan rasa percaya dan keterlibatan yang lebih besar di antara anggota. Dengan melibatkan berbagai ide dan masukan, solusi yang dihasilkan akan lebih relevan dan dapat diterima oleh masyarakat.</p>

                <p>Untuk menjaga semangat dan keterlibatan masyarakat, adakan acara rutin seperti lomba kebersihan lingkungan, penghargaan bagi individu atau kelompok yang berkontribusi besar, atau kampanye kreatif melalui seni dan budaya. Kegiatan ini dapat menjadi motivasi tambahan sekaligus sarana edukasi yang menarik.</p>

                <p>Evaluasi berkala sangat penting untuk meninjau efektivitas kegiatan. Beberapa langkah yang dapat diambil untuk evaluasi antara lain:</p>
                <ul>
                <li>Mengukur jumlah sampah yang berhasil dikurangi atau didaur ulang dari waktu ke waktu.</li>
                <li>Mengadakan survei kepuasan masyarakat untuk mengetahui dampak program terhadap pola pikir dan kebiasaan mereka.</li>
                <li>Melakukan diskusi evaluasi untuk mencari tahu tantangan yang dihadapi selama pelaksanaan program.</li>
                </ul>

                <p>Konsistensi adalah kunci keberhasilan dalam membangun komunitas yang peduli terhadap pengelolaan sampah. Langkah-langkah kecil yang dilakukan secara terus-menerus akan memberikan dampak besar dalam jangka panjang. Oleh karena itu, penting untuk tetap menjaga komitmen dan melibatkan sebanyak mungkin pihak dalam perjalanan ini.</p>

                <p>Pada akhirnya, perubahan dimulai dari langkah kecil yang konsisten. Bersama-sama, kita dapat menciptakan perubahan besar melalui langkah-langkah kolaboratif yang berkelanjutan. Jadilah bagian dari gerakan untuk membangun lingkungan yang lebih bersih, sehat, dan berkelanjutan. Setiap tindakan Anda akan menjadi inspirasi bagi orang lain.</p>
                ',
                'thumbnail' => 'https://waste4change.com/blog/wp-content/uploads/9D13FE3C-FBBC-4FD9-B5F2-CA92F569673B-1-350x233.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('learning_modules')->insert($learningModules);

        DB::table('learning_modules')->insert([
            [
        'id' => (string) \Str::uuid(),  // UUID unik
        'title' => 'Pengenalan Pengelolaan Sampah',
        'description' => 'Modul ini memberikan pemahaman dasar tentang pengelolaan sampah, jenis-jenis sampah, dan cara-cara efektif untuk mengelola sampah di lingkungan sekitar.',
        'content' => '
        <h2>1. Apa Itu Sampah?</h2>
        <p>Sampah adalah segala sesuatu yang tidak diinginkan dan dibuang oleh manusia setelah digunakan. Sampah dapat dibagi menjadi dua kategori utama, yaitu sampah organik dan sampah anorganik.</p>

        <h2>2. Jenis-Jenis Sampah</h2>
        <h3>a. Sampah Organik</h3>
        <p>Sampah organik adalah sampah yang berasal dari bahan-bahan alami dan dapat terurai dengan mudah di alam, seperti sisa makanan, daun, dan ranting.</p>

        <h3>b. Sampah Anorganik</h3>
        <p>Sampah anorganik terdiri dari bahan yang tidak dapat terurai secara alami, seperti plastik, kaca, logam, dan kertas.</p>

        <h2>3. Dampak Buruk Sampah Bagi Lingkungan</h2>
        <p>Sampah yang tidak dikelola dengan baik dapat menyebabkan polusi, pencemaran air, tanah, dan udara, serta dapat mengancam kesehatan manusia dan makhluk hidup lainnya.</p>

        <h2>4. Cara Mengelola Sampah</h2>
        <p>Pengelolaan sampah yang baik melibatkan beberapa tahapan:</p>
        <ul>
        <li><strong>Pengurangan Sampah</strong>: Mengurangi jumlah sampah yang dihasilkan dengan cara menggunakan barang-barang yang dapat digunakan kembali dan mengurangi penggunaan plastik sekali pakai.</li>
        <li><strong>Pemilahan Sampah</strong>: Memisahkan sampah organik dan anorganik untuk memudahkan proses pengolahan lebih lanjut.</li>
        <li><strong>Pengomposan</strong>: Mengolah sampah organik menjadi kompos yang dapat digunakan sebagai pupuk tanaman.</li>
        <li><strong>Daur Ulang</strong>: Mendaur ulang sampah anorganik seperti plastik, kertas, dan logam menjadi produk baru yang berguna.</li>
        </ul>

        <h2>5. Mengapa Daur Ulang Itu Penting?</h2>
        <p>Daur ulang membantu mengurangi sampah yang menumpuk di tempat pembuangan akhir, menghemat sumber daya alam, dan mengurangi polusi yang ditimbulkan oleh sampah.</p>

        <h2>6. Penutupan</h2>
        <p>Pengelolaan sampah yang efektif membutuhkan kesadaran dan partisipasi dari semua pihak. Mulailah dengan langkah kecil seperti memilah sampah di rumah dan mengurangi penggunaan plastik sekali pakai untuk menjaga kelestarian lingkungan kita.</p>
        ',
        'thumbnail' => 'https://example.com/images/sampah-thumbnail.jpg',  // URL gambar thumbnail
        'created_at' => now(),
        'updated_at' => now(),
    ],
    // Anda bisa menambahkan lebih banyak modul tentang topik ini sesuai kebutuhan
]);

    }
}
