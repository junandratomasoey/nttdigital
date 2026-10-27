<?php

namespace Database\Seeders;

use App\Models\Artikel;
use App\Models\Faq;
use App\Models\Layanan;
use App\Models\Portofolio;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

/**
 * Konten untuk website multi-halaman (detail layanan, portofolio, FAQ, artikel).
 * Aman dijalankan ulang di server production:
 *   php artisan db:seed --class=KontenWebsiteSeeder
 * - Layanan/portofolio: hanya mengisi kolom yang masih kosong.
 * - FAQ & artikel: dibuat jika belum ada (dicocokkan dari pertanyaan/slug).
 * - Pengaturan: hanya menambah key baru, tidak menimpa yang sudah diisi.
 */
class KontenWebsiteSeeder extends Seeder
{
    public function run(): void
    {
        $this->pengaturan();
        $this->layanan();
        $this->portofolio();
        $this->faq();
        $this->artikel();
    }

    private function isiJikaKosong($model, array $data): void
    {
        foreach ($data as $kolom => $nilai) {
            if (blank($model->{$kolom})) {
                $model->{$kolom} = $nilai;
            }
        }
        $model->save();
    }

    private function pengaturan(): void
    {
        $baru = [
            'jam_operasional'         => 'Senin – Sabtu, 08.00 – 20.00 WITA',
            'site_tiktok'             => '',
            'site_gmaps_embed'        => '',
            'seo_og_image'            => '',
            'seo_google_verification' => '',
            'tracking_ga4_id'         => '',
            'tracking_meta_pixel_id'  => '',
        ];
        foreach ($baru as $key => $value) {
            if (! SiteSetting::where('key', $key)->exists()) {
                SiteSetting::set($key, $value);
            }
        }
    }

    private function layanan(): void
    {
        $data = [
            'website-desa' => [
                'tagline' => 'Website resmi desa untuk transparansi informasi dan pelayanan warga yang lebih cepat.',
                'deskripsi' => 'Website profil desa lengkap dengan berita, transparansi APBDes, layanan surat online, dan etalase produk unggulan desa.',
                'fitur' => ['Profil desa, visi-misi & struktur perangkat', 'Berita & pengumuman desa', 'Transparansi APBDes & infografis', 'Layanan permohonan surat online', 'Etalase produk BUMDes & UMKM desa', 'Galeri foto kegiatan', 'Peta lokasi & batas wilayah', 'Panel admin untuk operator desa'],
                'konten' => '<h2>Desa yang terbuka dimulai dari informasi yang mudah diakses</h2><p>Website desa membantu pemerintah desa menyampaikan informasi kepada warga — termasuk warga yang merantau — secara cepat dan terbuka. Dari pengumuman kegiatan, laporan penggunaan Dana Desa, hingga potensi wisata dan produk unggulan, semuanya bisa diakses kapan saja dari HP.</p><h3>Cocok untuk</h3><ul><li>Pemerintah desa / kelurahan di seluruh NTT</li><li>BUMDes yang ingin memasarkan produk</li><li>Desa wisata yang ingin menarik pengunjung</li></ul><h3>Dikelola sendiri oleh operator desa</h3><p>Kami menyiapkan panel admin yang sederhana dan memberikan pelatihan, sehingga operator desa dapat memperbarui berita dan data tanpa harus menghubungi developer.</p>',
            ],
            'website-sekolah' => [
                'tagline' => 'Tampilkan prestasi sekolah dan permudah komunikasi dengan orang tua siswa.',
                'deskripsi' => 'Website sekolah dengan profil, berita & prestasi, galeri, informasi guru, dan pendaftaran siswa baru (PPDB) online.',
                'fitur' => ['Profil sekolah, sambutan kepala sekolah', 'Berita, agenda & pengumuman', 'Data guru dan tenaga kependidikan', 'Galeri prestasi & kegiatan', 'Formulir PPDB online', 'Unduhan dokumen (kalender akademik, dll.)', 'Panel admin untuk operator sekolah'],
                'konten' => '<h2>Wajah digital sekolah Anda</h2><p>Orang tua kini mencari informasi sekolah lewat internet sebelum mendaftarkan anaknya. Website sekolah yang rapi dan selalu diperbarui meningkatkan kepercayaan dan memudahkan komunikasi.</p><h3>PPDB lebih tertib</h3><p>Formulir pendaftaran online membantu panitia mengumpulkan data calon siswa dengan rapi dan mengurangi antrean di sekolah.</p>',
            ],
            'website-umkm' => [
                'tagline' => 'Katalog produk online dengan pemesanan langsung lewat WhatsApp.',
                'deskripsi' => 'Website toko/katalog untuk UMKM: tampilkan produk, harga, dan terima pesanan langsung ke WhatsApp Anda.',
                'fitur' => ['Katalog produk dengan foto & harga', 'Tombol pesan via WhatsApp per produk', 'Halaman profil & cerita usaha', 'Lokasi toko di Google Maps', 'Testimoni pelanggan', 'Panel admin untuk kelola produk'],
                'konten' => '<h2>Jualan lebih luas, tanpa ribet</h2><p>Banyak pelanggan menanyakan “ada katalognya?”. Dengan website katalog, Anda cukup membagikan satu link — pelanggan bisa melihat semua produk dan langsung memesan lewat WhatsApp.</p><p>Cocok untuk tenun ikat, kuliner khas NTT, kerajinan, kafe, toko bangunan, hingga jasa.</p>',
            ],
            'undangan-digital' => [
                'tagline' => 'Undangan pernikahan online yang elegan, mudah dibagikan, dan hemat biaya.',
                'deskripsi' => 'Undangan digital dengan countdown, peta lokasi, RSVP, galeri foto, musik, dan buku ucapan — tinggal bagikan link ke tamu.',
                'fitur' => ['Pilihan tema elegan bernuansa NTT & modern', 'Nama tamu personal di setiap link', 'Hitung mundur hari-H', 'Peta lokasi acara', 'Konfirmasi kehadiran (RSVP)', 'Galeri foto pre-wedding & musik', 'Buku ucapan & doa'],
                'konten' => '<h2>Bagikan kabar bahagia dengan satu link</h2><p>Undangan digital memudahkan Anda mengundang keluarga dan sahabat di mana pun — termasuk yang di luar NTT — tanpa biaya cetak dan kirim. Tamu bisa langsung membuka peta lokasi dan mengonfirmasi kehadiran.</p>',
            ],
            'website-perusahaan' => [
                'tagline' => 'Company profile profesional untuk membangun kredibilitas bisnis Anda.',
                'deskripsi' => 'Website company profile untuk perusahaan, CV, kontraktor, dan konsultan: profil, layanan, portofolio proyek, dan kontak.',
                'fitur' => ['Profil perusahaan & legalitas', 'Halaman layanan / produk', 'Portofolio proyek', 'Struktur tim', 'Formulir permintaan penawaran', 'Email dengan domain perusahaan', 'Optimasi SEO dasar'],
                'konten' => '<h2>Kredibilitas dimulai dari website</h2><p>Calon mitra dan pemberi kerja biasanya memeriksa website perusahaan sebelum memutuskan. Company profile yang profesional menunjukkan bahwa usaha Anda serius dan terpercaya — sangat membantu saat mengikuti tender atau menjalin kerja sama.</p>',
            ],
            'website-gereja' => [
                'tagline' => 'Sarana informasi jemaat: jadwal ibadah, warta, dan kegiatan pelayanan.',
                'deskripsi' => 'Website gereja / masjid dengan jadwal ibadah, warta jemaat, renungan, galeri kegiatan, dan informasi persembahan/donasi.',
                'fitur' => ['Jadwal ibadah & kegiatan', 'Warta jemaat / pengumuman mingguan', 'Renungan atau kajian', 'Profil pelayan / pengurus', 'Galeri kegiatan', 'Informasi persembahan & donasi', 'Siaran langsung (embed YouTube)'],
                'konten' => '<h2>Melayani jemaat lebih dekat</h2><p>Website membantu jemaat — termasuk yang sedang merantau — tetap terhubung dengan kegiatan rumah ibadah. Warta mingguan, jadwal, dan siaran ibadah dapat diakses dari mana saja.</p>',
            ],
            'website-hotel' => [
                'tagline' => 'Tampilkan kamar dan fasilitas, terima permintaan booking langsung.',
                'deskripsi' => 'Website hotel, homestay, dan penginapan: daftar kamar & tarif, galeri fasilitas, lokasi, dan permintaan reservasi via WhatsApp.',
                'fitur' => ['Daftar tipe kamar, fasilitas & tarif', 'Galeri foto berkualitas', 'Formulir permintaan reservasi', 'Tombol booking via WhatsApp', 'Lokasi & destinasi wisata sekitar', 'Tautan ke OTA (Traveloka, Booking.com)'],
                'konten' => '<h2>Kurangi ketergantungan pada OTA</h2><p>Dengan website sendiri, tamu dapat memesan langsung kepada Anda tanpa potongan komisi. Cocok untuk hotel, homestay, dan penginapan di destinasi wisata NTT seperti Labuan Bajo, Kupang, Rote, dan Sumba.</p>',
            ],
            'lainnya' => [
                'tagline' => 'Punya kebutuhan khusus? Kami bantu rancang solusinya.',
                'deskripsi' => 'Sistem informasi custom, aplikasi web instansi, WebGIS, dan kebutuhan digital lain sesuai permintaan.',
                'fitur' => ['Sistem informasi & aplikasi web custom', 'Aplikasi peta (WebGIS)', 'Sistem arsip & dokumen digital', 'Integrasi dengan sistem yang sudah ada', 'Maintenance & pengembangan lanjutan'],
                'konten' => '<h2>Solusi sesuai kebutuhan</h2><p>Selain website, kami berpengalaman membangun aplikasi web untuk instansi: sistem arsip digital, pelayanan publik, absensi, hingga peta interaktif. Ceritakan kebutuhan Anda dan kami bantu rancang solusinya.</p>',
            ],
        ];

        foreach ($data as $slug => $isi) {
            if ($layanan = Layanan::where('slug', $slug)->first()) {
                $this->isiJikaKosong($layanan, $isi);
            }
        }
    }

    private function portofolio(): void
    {
        $data = [
            'Desa'     => ['fitur' => ['Profil & struktur perangkat desa', 'Berita desa', 'Layanan surat online', 'Etalase produk desa'], 'teknologi' => ['Laravel', 'Tailwind CSS', 'Filament']],
            'Sekolah'  => ['fitur' => ['Profil & sambutan kepala sekolah', 'Berita & agenda', 'Galeri prestasi', 'PPDB online'], 'teknologi' => ['Laravel', 'Tailwind CSS', 'Filament']],
            'UMKM'     => ['fitur' => ['Katalog produk', 'Pesan via WhatsApp', 'Profil usaha'], 'teknologi' => ['Laravel', 'Tailwind CSS', 'Alpine.js']],
            'Undangan' => ['fitur' => ['Countdown hari-H', 'RSVP', 'Galeri foto', 'Buku ucapan', 'Peta lokasi'], 'teknologi' => ['Laravel', 'Alpine.js', 'Leaflet']],
            'Gereja'   => ['fitur' => ['Jadwal ibadah', 'Warta jemaat', 'Informasi donasi'], 'teknologi' => ['Laravel', 'Tailwind CSS']],
            'Hotel'    => ['fitur' => ['Daftar kamar & tarif', 'Galeri fasilitas', 'Permintaan booking'], 'teknologi' => ['Laravel', 'Tailwind CSS']],
        ];

        foreach (Portofolio::all() as $porto) {
            if (isset($data[$porto->kategori])) {
                $this->isiJikaKosong($porto, $data[$porto->kategori]);
            }
        }
    }

    private function faq(): void
    {
        $faqs = [
            ['Umum', true,  'Berapa lama proses pembuatan website?', 'Tergantung jenis dan fiturnya. Website sederhana (profil/katalog) umumnya selesai dalam 1–2 minggu, sedangkan website dengan fitur khusus bisa 3–6 minggu. Jadwal pasti kami sampaikan di penawaran.'],
            ['Umum', true,  'Apakah saya bisa mengubah isi website sendiri?', 'Bisa. Paket Profesional ke atas dilengkapi panel admin sehingga Anda dapat menambah berita, foto, dan produk sendiri. Kami juga memberikan panduan penggunaannya.'],
            ['Umum', true,  'Apakah melayani klien di luar Kota Kupang?', 'Ya. Kami melayani seluruh wilayah NTT — Flores, Sumba, Alor, Rote, Sabu, dan lainnya — maupun luar NTT. Koordinasi dapat dilakukan lewat WhatsApp dan video call.'],
            ['Umum', false, 'Apakah website-nya tampil bagus di HP?', 'Ya. Semua website kami dibuat responsif sehingga nyaman dibuka di HP, tablet, maupun komputer.'],
            ['Harga & Pembayaran', true, 'Apakah harga sudah termasuk domain dan hosting?', 'Rincian domain dan hosting dicantumkan dengan jelas di penawaran sesuai paket yang dipilih, sehingga tidak ada biaya tersembunyi.'],
            ['Harga & Pembayaran', false, 'Bagaimana sistem pembayarannya?', 'Pembayaran dilakukan bertahap: uang muka (DP) sebelum pengerjaan dimulai, lalu pelunasan setelah website selesai dan Anda setujui. Detailnya disepakati di penawaran.'],
            ['Harga & Pembayaran', false, 'Apakah bisa untuk pengadaan instansi pemerintah / desa?', 'Bisa. Kami dapat menyiapkan penawaran harga dan dokumen pendukung yang dibutuhkan untuk proses pengadaan.'],
            ['Teknis', false, 'Apakah website akan muncul di Google?', 'Website kami dibangun dengan dasar SEO yang baik (struktur rapi, cepat, sitemap). Kami juga membantu mendaftarkannya ke Google Search Console agar lebih cepat terindeks.'],
            ['Teknis', false, 'Bagaimana jika website bermasalah setelah selesai?', 'Setiap paket mendapat masa revisi/dukungan sesuai ketentuan paket. Setelah itu tersedia layanan maintenance berkala jika dibutuhkan.'],
        ];

        foreach ($faqs as $i => [$kategori, $beranda, $tanya, $jawab]) {
            Faq::firstOrCreate(
                ['pertanyaan' => $tanya],
                ['jawaban' => $jawab, 'kategori' => $kategori, 'tampil_di_beranda' => $beranda, 'urutan' => $i + 1, 'aktif' => true]
            );
        }
    }

    private function artikel(): void
    {
        $artikels = [
            [
                'judul' => 'Kenapa Desa di NTT Perlu Punya Website Resmi?',
                'slug' => 'kenapa-desa-di-ntt-perlu-punya-website-resmi',
                'kategori' => 'Digitalisasi Desa',
                'tags' => ['website desa', 'dana desa', 'transparansi', 'NTT'],
                'ringkasan' => 'Website desa bukan sekadar tren. Ini sarana transparansi, pelayanan, dan promosi potensi desa yang bisa diakses warga di mana pun.',
                'konten' => '<p>Hampir semua warga desa di NTT kini memegang HP. Informasi yang dulu hanya ditempel di papan pengumuman kantor desa sekarang bisa sampai ke warga — termasuk yang merantau ke Kupang, Bali, atau Kalimantan — melalui website desa.</p><h2>1. Transparansi pengelolaan Dana Desa</h2><p>Website menjadi tempat yang tepat untuk mempublikasikan APBDes, realisasi anggaran, dan dokumentasi pembangunan. Keterbukaan ini membangun kepercayaan warga terhadap pemerintah desa.</p><h2>2. Pelayanan administrasi lebih cepat</h2><p>Dengan formulir permohonan surat online, warga dapat mengajukan surat keterangan tanpa harus bolak-balik ke kantor desa. Operator cukup memproses dan memberi kabar ketika surat siap diambil.</p><h2>3. Promosi potensi dan produk desa</h2><p>Tenun ikat, kopi, madu hutan, garam, hingga destinasi wisata alam — semuanya bisa dipromosikan ke pembeli dan wisatawan dari luar daerah.</p><h2>4. Arsip informasi yang rapi</h2><p>Berita kegiatan, profil perangkat, dan data desa tersimpan rapi dan mudah dicari, tidak hilang ketika terjadi pergantian perangkat desa.</p><h2>Mulai dari yang sederhana</h2><p>Desa tidak perlu langsung membuat sistem yang rumit. Mulailah dari profil, berita, dan transparansi anggaran, lalu kembangkan fitur sesuai kebutuhan.</p>',
            ],
            [
                'judul' => 'Undangan Digital vs Undangan Cetak: Mana yang Lebih Cocok?',
                'slug' => 'undangan-digital-vs-undangan-cetak',
                'kategori' => 'Undangan',
                'tags' => ['undangan digital', 'pernikahan', 'tips'],
                'ringkasan' => 'Membandingkan undangan digital dan cetak dari sisi biaya, jangkauan, dan kepraktisan — plus tips menggabungkan keduanya.',
                'konten' => '<p>Menyiapkan pernikahan berarti banyak keputusan, termasuk soal undangan. Saat ini banyak pasangan memilih undangan digital, sebagian tetap mencetak, dan tidak sedikit yang memakai keduanya.</p><h2>Kelebihan undangan digital</h2><ul><li><strong>Hemat biaya</strong> — tidak ada biaya cetak dan pengiriman.</li><li><strong>Jangkauan luas</strong> — keluarga di luar pulau cukup menerima link lewat WhatsApp.</li><li><strong>Fitur lengkap</strong> — peta lokasi, hitung mundur, galeri foto, RSVP, dan buku ucapan.</li><li><strong>Mudah diperbarui</strong> — jika ada perubahan jam atau lokasi, cukup ubah sekali.</li></ul><h2>Kapan undangan cetak tetap dibutuhkan?</h2><p>Untuk orang tua, tokoh adat, atau tamu kehormatan, undangan cetak sering dianggap lebih sopan. Di banyak keluarga di NTT, mengantar undangan secara langsung juga merupakan bagian dari adat.</p><h2>Solusi terbaik: gabungkan keduanya</h2><p>Cetak dalam jumlah terbatas untuk tamu khusus, lalu gunakan undangan digital untuk teman, rekan kerja, dan keluarga jauh. Anda bisa menambahkan kode QR menuju undangan digital di undangan cetak.</p>',
            ],
            [
                'judul' => '5 Hal yang Perlu Disiapkan Sebelum Membuat Website Sekolah',
                'slug' => '5-hal-yang-perlu-disiapkan-sebelum-membuat-website-sekolah',
                'kategori' => 'Sekolah',
                'tags' => ['website sekolah', 'PPDB', 'panduan'],
                'ringkasan' => 'Agar pembuatan website sekolah berjalan lancar, siapkan lima hal ini terlebih dahulu: tujuan, konten, foto, pengelola, dan anggaran.',
                'konten' => '<p>Website sekolah yang baik bukan hanya soal tampilan. Persiapan yang matang membuat proses pembuatan lebih cepat dan website benar-benar terpakai setelah jadi.</p><h2>1. Tentukan tujuan utama</h2><p>Apakah untuk informasi PPDB, menampilkan prestasi, atau komunikasi dengan orang tua? Tujuan ini menentukan fitur yang diprioritaskan.</p><h2>2. Kumpulkan konten dasar</h2><p>Sejarah singkat, visi-misi, sambutan kepala sekolah, data guru, dan program unggulan. Konten dalam bentuk dokumen Word sudah cukup.</p><h2>3. Siapkan foto berkualitas</h2><p>Foto gedung, ruang kelas, kegiatan, dan prestasi siswa. Foto yang terang dan jelas membuat website terlihat jauh lebih profesional.</p><h2>4. Tunjuk pengelola website</h2><p>Website yang tidak pernah diperbarui akan cepat ditinggalkan. Tunjuk satu atau dua operator yang akan dilatih untuk mengunggah berita dan pengumuman.</p><h2>5. Rencanakan anggaran tahunan</h2><p>Selain biaya pembuatan, sisihkan anggaran untuk perpanjangan domain dan hosting setiap tahun agar website tetap aktif.</p>',
            ],
        ];

        foreach ($artikels as $a) {
            Artikel::firstOrCreate(['slug' => $a['slug']], array_merge($a, [
                'status'  => 'draf',   // tinjau dulu di admin, lalu ubah ke "Terbit"
                'penulis' => 'Tim NTT Digital',
            ]));
        }
    }
}
