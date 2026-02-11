<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyNewsSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure we have an author
        $author = User::first();
        if (!$author) {
            $author = User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // Get National Region
        $nationalRegion = Region::where('level', 'national')->first();
        // If no national region, try to get any region, or create one
        if (!$nationalRegion) {
            $nationalRegion = Region::firstOrCreate(
                ['level' => 'national'],
                ['name' => 'Nasional']
            );
        }

        $newsItems = [
            [
                'title' => 'DPC LSM Harimau Banjarnegara Audensi Bakesbangpol Menyoal Program MBG',
                'content' => "BANJARNEGARA – Dewan Pimpinan Cabang (DPC) Lembaga Swadaya Masyarakat (LSM) Harimau Kabupaten Banjarnegara menggelar audiensi bersama sejumlah pihak di Aula Badan Kesatuan Bangsa dan Politik (Bakesbangpol) Banjarnegara. Audiensi tersebut membahas berbagai persoalan dalam pelaksanaan Program Makan Bergizi Gratis (MBG), terutama terkait mutu makanan, transparansi anggaran, serta mekanisme pengawasan.

Ketua DPC LSM Harimau Banjarnegara, Prakas Pamuji Wijaya, menyebut langkah ini diambil setelah pihaknya menerima sejumlah laporan dari masyarakat terkait kelayakan menu MBG di beberapa sekolah. 'Kami menekankan pentingnya kelayakan gizi dan mutu makanan yang diberikan kepada penerima manfaat. Program ini tidak cukup hanya memenuhi unsur gizi, tetapi juga harus menjamin kualitas dan keamanan makanan yang dikonsumsi,' ujar Prakas.

Selain persoalan gizi, DPC LSM Harimau Kabupaten Banjarnegara juga menyoroti potensi monopoli dalam pengadaan bahan pangan. Mereka meminta Dinas Perindustrian, Koperasi, dan UMKM (Indakop) Banjarnegara memperketat pengawasan terhadap harga bahan pangan agar tidak terjadi praktik monopoli yang merugikan.

Menanggapi hal itu, Ketua DPRD Banjarnegara, Anas Hidayat, mengakui program Makan Bergizi Gratis merupakan pekerjaan besar yang membutuhkan sinergi dari seluruh pihak. Koordinator Wilayah Badan Gizi Nasional (BGN) Banjarnegara, Irma Lusita, juga mengapresiasi langkah LSM Harimau sebagai bentuk kontrol sosial dari masyarakat.",
                'image_path' => 'news/mbg.png',
                'source' => 'Times Indonesia',
                'created_at' => '2025-10-09 10:00:00',
            ],
            [
                'title' => 'LSM Harimau Jateng: Sistem Polri Saat Ini Sudah Efektif dan Dirasakan Masyarakat',
                'content' => "BANJARNEGARA – Wacana penempatan institusi Polri di bawah kementerian kembali menjadi perbincangan di tingkat nasional. Namun di daerah, pandangan berbeda muncul dari LSM Harapan Rakyat Indonesia Maju (Harimau) Jawa Tengah.

Sekretaris Wilayah LSM Harimau Provinsi Jawa Tengah (Jateng), M. Ruswanto, menilai keputusan Polri untuk tetap berada langsung di bawah Presiden adalah langkah yang tepat demi menjaga efektivitas pelayanan keamanan. Ruswanto mengatakan, selama ini berbagai daerah merasakan langsung kehadiran Polri melalui peran Bhabinkamtibmas dalam menjaga ketertiban masyarakat.

'Bhabinkamtibmas itu sangat dekat dengan masyarakat. Kami bisa berkoordinasi kapan saja jika ada persoalan yang butuh penanganan cepat,' ujar Ruswanto. Ia menilai, jika Polri berada di bawah kementerian, dikhawatirkan akan muncul rantai birokrasi yang lebih panjang.

'Keamanan di daerah sering kali membutuhkan respons yang cepat, seperti konflik warga atau gangguan kamtibmas lainnya. Kami tidak ingin ada birokrasi yang memperlambat penanganan di lapangan,' jelasnya.",
                'image_path' => 'news/polri.jpg',
                'source' => 'Berita Bersatu',
                'created_at' => '2026-01-28 10:00:00',
            ],
            [
                'title' => 'LSM Harimau Ciamis Jebak Sindikat Pencurian Kendaraan COD ke Mapolsek Banjarsari',
                'content' => "CIAMIS – Anggota LSM Harimau DPC Ciamis berhasil membantu aparat kepolisian dalam mengungkap sindikat pencurian kendaraan bermotor. Dengan menggunakan metode Cash On Delivery (COD) sebagai pancingan, anggota LSM Harimau berhasil menjebak para pelaku yang hendak menjual motor hasil curian.

Aksi penjebakan ini dilakukan di wilayah Banjarsari, Ciamis. Setelah para pelaku terpancing untuk bertemu, anggota LSM Harimau segera berkoordinasi dengan Polsek Banjarsari. Sebanyak lima orang terduga pelaku berhasil diamankan dalam operasi tersebut.

Para pelaku kemudian digelandang ke Mapolsek Banjarsari untuk menjalani pemeriksaan lebih lanjut. Aksi ini mendapat apresiasi dari masyarakat karena dinilai membantu menciptakan rasa aman di lingkungan Ciamis dan sekitarnya.",
                'image_path' => 'news/curanmor.jpg',
                'source' => 'Bandung Berita',
                'created_at' => '2025-10-14 10:00:00',
            ],
            [
                'title' => 'Ribuan Massa LSM Harimau Kepung PT Blesscon Banjarnegara, Tuntut Audit Izin dan Hak Pekerja',
                'content' => "BANJARNEGARA – Ribuan massa yang tergabung dalam Lembaga Swadaya Masyarakat (LSM) Harimau menggelar aksi unjuk rasa besar-besaran di jalur utama menuju pabrik bata ringan PT Superior Prima Sukses Tbk (BLES) atau PT Blesscon, Desa Purwonegoro, Kabupaten Banjarnegara, Kamis (29/1/2026).

Aksi demonstrasi ini dilakukan sebagai bentuk protes terhadap dugaan ketidakjelasan legalitas operasional PT Blesscon serta pengabaian hak-hak pekerja. Massa menuntut transparansi perizinan perusahaan dan pertanggungjawaban atas dugaan pelanggaran ketenagakerjaan.

Ketua Umum LSM Harimau, Tonny Hidayat, S.H., dalam orasinya menyampaikan bahwa PT Blesscon diduga telah beroperasi tanpa mengantongi Persetujuan Bangunan Gedung (PBG) sebagaimana mestinya. Selain itu, massa juga menyoroti nasib pekerja, khususnya kasus kecelakaan kerja yang menimpa salah satu pekerja yang belum mendapatkan hak jaminan kecelakaan kerja yang memadai.

Massa mengancam akan kembali menggelar aksi dengan jumlah yang lebih besar jika tuntutan mereka tidak segera dipenuhi oleh pihak manajemen perusahaan dan pemerintah daerah.",
                'image_path' => 'news/blesscon.jpg',
                'source' => 'Metro Surya',
                'created_at' => '2026-01-29 10:00:00',
            ],
        ];

        foreach ($newsItems as $item) {
            News::updateOrCreate(
                ['title' => $item['title']],
                [
                    'slug' => Str::slug($item['title']),
                    'content' => $item['content'],
                    'image_path' => $item['image_path'],
                    'source' => $item['source'],
                    'author_id' => $author->id,
                    'region_id' => $nationalRegion->id, // Assign to National Region
                    'is_published' => true,
                    'created_at' => $item['created_at'],
                ]
            );
        }
    }
}
