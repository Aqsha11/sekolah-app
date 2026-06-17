<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Prestasi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyImageSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating dummy data with images...');

        $this->seedGuru();
        $this->seedPrestasi();
        $this->seedBerita();
        $this->seedGaleri();
        $this->seedFasilitas();

        $this->command->info('Dummy data created successfully.');
    }

    protected function makeImage(string $dir, string $filename, int $w, int $h, array $bg, string $label1, string $label2 = ''): void
    {
        $path = storage_path("app/public/{$dir}");
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $img = imagecreatetruecolor($w, $h);
        $bgColor = imagecolorallocate($img, $bg[0], $bg[1], $bg[2]);
        imagefill($img, 0, 0, $bgColor);

        $white = imagecolorallocate($img, 255, 255, 255);
        $gray = imagecolorallocate($img, 220, 220, 220);

        $font = null;
        if (function_exists('imagettftext')) {
            $candidates = [
                'C:\Windows\Fonts\arial.ttf',
                'C:\Windows\Fonts\segoeui.ttf',
                'C:\Windows\Fonts\calibri.ttf',
                '/usr/share/fonts/truetype/dejavu/DejaVuSans.ttf',
                '/usr/share/fonts/TTF/DejaVuSans.ttf',
            ];
            foreach ($candidates as $f) {
                if (file_exists($f)) {
                    $font = $f;
                    break;
                }
            }
        }

        if ($font) {
            $bbox = imagettfbbox(16, 0, $font, $label1);
            $x = ($w - ($bbox[2] - $bbox[0])) / 2;
            $y = $h / 2 - ($bbox[1] - $bbox[7]) / 2 - 10;
            imagettftext($img, 16, 0, (int)$x, (int)$y, $white, $font, $label1);

            if ($label2) {
                $cls = strlen($label2) > 40 ? 10 : 12;
                $bbox2 = imagettfbbox($cls, 0, $font, $label2);
                $x2 = ($w - ($bbox2[2] - $bbox2[0])) / 2;
                $y2 = $y + 30;
                imagettftext($img, $cls, 0, (int)$x2, (int)$y2, $gray, $font, $label2);
            }
        } else {
            $cx = $w / 2;
            $cy = $h / 2 - 10;
            $tw = strlen($label1) * imagefontwidth(4);
            $x = (int)($cx - $tw / 2);
            $y = (int)($cy - imagefontheight(4) / 2);
            imagestring($img, 4, max(0, $x), max(0, $y), $label1, $white);

            if ($label2) {
                $tw2 = strlen($label2) * imagefontwidth(3);
                $x2 = (int)($cx - $tw2 / 2);
                imagestring($img, 3, max(0, $x2), $y + 20, $label2, $gray);
            }
        }

        imagejpeg($img, $path . '/' . $filename, 85);
        imagedestroy($img);
    }

    protected function seedGuru(): void
    {
        $gurus = [
            ['name' => 'Dr. H. Ahmad Fauzi, M.Pd.', 'nip' => '196501011990031005', 'subject' => '-', 'position' => 'Kepala Sekolah', 'email' => 'kepalasekolah@sekolah.test', 'phone' => '081211111111', 'bio' => 'Kepala sekolah berpengalaman dengan visi pendidikan yang kuat.', 'is_active' => true],
            ['name' => 'Rina Marlina, S.Pd.', 'nip' => '197203151998042006', 'subject' => 'Matematika', 'position' => 'Guru Mata Pelajaran', 'email' => 'rina.marlina@sekolah.test', 'phone' => '081211111112', 'bio' => 'Guru matematika yang inovatif dan menyenangkan.', 'is_active' => true],
            ['name' => 'Bambang Supriyadi, S.Pd.', 'nip' => '197506202001121004', 'subject' => 'Bahasa Indonesia', 'position' => 'Guru Mata Pelajaran', 'email' => 'bambang.supriyadi@sekolah.test', 'phone' => '081211111113', 'bio' => 'Guru bahasa Indonesia yang aktif dalam kegiatan literasi sekolah.', 'is_active' => true],
            ['name' => 'Dewi Sartika, S.Pd.', 'nip' => '198012052005012008', 'subject' => 'Bahasa Inggris', 'position' => 'Guru Mata Pelajaran', 'email' => 'dewi.sartika@sekolah.test', 'phone' => '081211111114', 'bio' => 'Guru bahasa Inggris dengan pengalaman mengajar IELTS.', 'is_active' => true],
            ['name' => 'Hendra Kusuma, S.Pd.', 'nip' => '198203102006041010', 'subject' => 'Fisika', 'position' => 'Kepala Laboratorium', 'email' => 'hendra.kusuma@sekolah.test', 'phone' => '081211111115', 'bio' => 'Guru fisika yang aktif dalam penelitian dan lomba sains.', 'is_active' => true],
            ['name' => 'Siti Rahmawati, S.Pd.', 'nip' => '198307122007012012', 'subject' => 'Kimia', 'position' => 'Guru Mata Pelajaran', 'email' => 'siti.rahmawati@sekolah.test', 'phone' => '081211111116', 'bio' => 'Guru kimia dengan metode pembelajaran praktik yang interaktif.', 'is_active' => true],
            ['name' => 'Agus Wijaya, S.Pd.', 'nip' => '198408152008031011', 'subject' => 'Biologi', 'position' => 'Guru Mata Pelajaran', 'email' => 'agus.wijaya@sekolah.test', 'phone' => '081211111117', 'bio' => 'Guru biologi yang gemar mengadakan penelitian lapangan.', 'is_active' => true],
            ['name' => 'Fitriani, S.Pd.', 'nip' => '198505202009042009', 'subject' => 'Sejarah', 'position' => 'Wakil Kepala Sekolah Bidang Kurikulum', 'email' => 'fitriani@sekolah.test', 'phone' => '081211111118', 'bio' => 'Guru sejarah yang aktif dalam pengembangan kurikulum.', 'is_active' => true],
            ['name' => 'Dodi Firmansyah, S.Pd.', 'nip' => '198606252010011013', 'subject' => 'Penjaskes', 'position' => 'Pembina Ekstrakurikuler', 'email' => 'dodi.firmansyah@sekolah.test', 'phone' => '081211111119', 'bio' => 'Pelatih tim basket dan futsal sekolah.', 'is_active' => true],
            ['name' => 'Nurul Hidayah, S.Pd.', 'nip' => '198707302011012014', 'subject' => 'BK', 'position' => 'Guru Bimbingan Konseling', 'email' => 'nurul.hidayah@sekolah.test', 'phone' => '081211111120', 'bio' => 'Konselor yang peduli dengan perkembangan mental siswa.', 'is_active' => true],
            ['name' => 'Eko Prasetyo, S.Kom.', 'nip' => '198808052012011015', 'subject' => 'Informatika/TIK', 'position' => 'Kepala Laboratorium Komputer', 'email' => 'eko.prasetyo@sekolah.test', 'phone' => '081211111121', 'bio' => 'Guru TIK yang ahli dalam pengembangan sistem informasi sekolah.', 'is_active' => true],
            ['name' => 'Ani Susilowati, S.Pd.', 'nip' => '198909102013022016', 'subject' => 'Seni Budaya', 'position' => 'Pembina Ekstrakurikuler', 'email' => 'ani.susilowati@sekolah.test', 'phone' => '081211111122', 'bio' => 'Pembina paduan suara dan seni tari sekolah.', 'is_active' => true],
        ];

        $colors = [
            [41, 128, 185], [231, 76, 60], [46, 204, 113], [155, 89, 182],
            [52, 73, 94], [243, 156, 18], [26, 188, 156], [230, 126, 34],
            [149, 165, 166], [142, 68, 173], [39, 174, 96], [211, 84, 0],
        ];

        foreach ($gurus as $i => $data) {
            $guru = Guru::firstOrCreate(['nip' => $data['nip']], $data);

            $filename = 'guru_' . ($i + 1) . '.jpg';
            $fullPath = storage_path("app/public/guru/{$filename}");
            if (!file_exists($fullPath)) {
                $this->makeImage('guru', $filename, 400, 400, $colors[$i], $data['subject'] ?: 'Guru', $data['name']);
            }

            if (!$guru->photo) {
                $guru->update(['photo' => $filename]);
            }
            $this->command->info("  Guru: {$data['name']}");
        }
    }

    protected function seedPrestasi(): void
    {
        $prestasis = [
            ['title' => 'Juara 1 Olimpiade Matematika Tingkat Nasional', 'category' => 'Akademik', 'level' => 'Nasional', 'year' => '2025', 'description' => 'Siswa kami berhasil meraih juara 1 Olimpiade Matematika yang diselenggarakan oleh Kementerian Pendidikan.'],
            ['title' => 'Juara 2 Lomba Debat Bahasa Inggris', 'category' => 'Akademik', 'level' => 'Provinsi', 'year' => '2025', 'description' => 'Tim debat bahasa Inggris berhasil meraih juara 2 tingkat provinsi DKI Jakarta.'],
            ['title' => 'Juara 1 Lomba Pidato Bahasa Indonesia', 'category' => 'Akademik', 'level' => 'Kota', 'year' => '2025', 'description' => 'Prestasi membanggakan dalam lomba pidato tingkat kota.'],
            ['title' => 'Juara 3 Olimpiade Sains Nasional (Fisika)', 'category' => 'Akademik', 'level' => 'Nasional', 'year' => '2024', 'description' => 'Meraih medali perunggu Olimpiade Sains Nasional bidang Fisika.'],
            ['title' => 'Juara 1 Turnamen Futsal Antar Sekolah', 'category' => 'Olahraga', 'level' => 'Kota', 'year' => '2025', 'description' => 'Tim futsal sekolah berhasil menjadi juara 1 turnamen futsal se-DKI Jakarta.'],
            ['title' => 'Juara 2 Lomba Band Pelajar', 'category' => 'Seni', 'level' => 'Provinsi', 'year' => '2025', 'description' => 'Band sekolah meraih juara 2 lomba band pelajar tingkat provinsi.'],
            ['title' => 'Juara 1 Lomba Tari Tradisional', 'category' => 'Seni', 'level' => 'Nasional', 'year' => '2024', 'description' => 'Siswa meraih juara 1 lomba tari tradisional tingkat nasional.'],
            ['title' => 'Juara Harapan 1 Olimpiade Kimia', 'category' => 'Akademik', 'level' => 'Nasional', 'year' => '2024', 'description' => 'Prestasi membanggakan di Olimpiade Kimia Nasional.'],
            ['title' => 'Juara 3 Lomba Cipta Puisi', 'category' => 'Seni', 'level' => 'Provinsi', 'year' => '2025', 'description' => 'Siswa berhasil meraih juara 3 lomba cipta puisi tingkat provinsi.'],
            ['title' => 'Juara 1 Lomba Mading', 'category' => 'Seni', 'level' => 'Kota', 'year' => '2025', 'description' => 'Majalah dinding sekolah meraih juara 1 lomba mading tingkat kota.'],
            ['title' => 'Juara 2 Lomba Cerdas Cermat Sejarah', 'category' => 'Akademik', 'level' => 'Provinsi', 'year' => '2024', 'description' => 'Tim cerdas cermat meraih juara 2 tingkat provinsi.'],
            ['title' => 'Juara 1 Pencak Silat Tingkat Nasional', 'category' => 'Olahraga', 'level' => 'Nasional', 'year' => '2025', 'description' => 'Siswa meraih juara 1 pencak silat kategori putra tingkat nasional.'],
        ];

        $categoryColors = [
            'Akademik' => [41, 128, 185],
            'Olahraga' => [46, 204, 113],
            'Seni' => [155, 89, 182],
        ];

        foreach ($prestasis as $i => $data) {
            $prestasi = Prestasi::firstOrCreate(
                ['title' => $data['title']],
                $data
            );

            $filename = 'prestasi_' . ($i + 1) . '.jpg';
            $fullPath = storage_path("app/public/prestasi/{$filename}");
            if (!file_exists($fullPath)) {
                $cat = $data['category'];
                $color = $categoryColors[$cat] ?? [52, 73, 94];
                $this->makeImage('prestasi', $filename, 800, 600, $color, $data['category'], $data['title']);
            }

            if (!$prestasi->image) {
                $prestasi->update(['image' => $filename]);
            }
            $this->command->info("  Prestasi: {$data['title']}");
        }
    }

    protected function seedBerita(): void
    {
        $users = User::pluck('id')->toArray();
        $adminId = User::where('email', 'admin@sekolah.test')->value('id') ?: ($users[0] ?? 1);

        $beritas = [
            ['title' => 'Kegiatan MPLS Tahun Ajaran 2025/2026 Berjalan Lancar', 'slug' => 'kegiatan-mpls-tahun-ajaran-2025-2026', 'category' => 'Kegiatan', 'date' => '2025-07-15', 'is_published' => true, 'views' => 245, 'content' => "Masa Pengenalan Lingkungan Sekolah (MPLS) tahun ajaran 2025/2026 telah berlangsung dengan sukses selama tiga hari. Kegiatan ini diikuti oleh seluruh siswa baru kelas X dengan antusiasme yang tinggi.\n\nBerbagai kegiatan telah dilaksanakan, mulai dari pengenalan fasilitas sekolah, perkenalan dengan guru dan karyawan, hingga berbagai games edukatif yang bertujuan untuk mempererat kebersamaan antar siswa baru.\n\nKepala SMA Negeri 1 Jakarta, Dr. H. Ahmad Fauzi, M.Pd., dalam sambutannya menyampaikan bahwa MPLS bukan hanya sekedar pengenalan lingkungan, tetapi juga awal dari perjalanan siswa dalam menuntut ilmu di sekolah ini."],
            ['title' => 'SMA Negeri 1 Jakarta Meraih Akreditasi A', 'slug' => 'sma-negeri-1-jakarta-meraih-akreditasi-a', 'category' => 'Prestasi', 'date' => '2025-06-20', 'is_published' => true, 'views' => 389, 'content' => "SMA Negeri 1 Jakarta berhasil meraih akreditasi A (Unggul) dari Badan Akreditasi Nasional Sekolah/Madrasah (BAN-SM). Pencapaian ini menunjukkan kualitas pendidikan yang terus meningkat.\n\nProses akreditasi meliputi penilaian terhadap delapan standar nasional pendidikan, yaitu standar isi, proses, kompetensi lulusan, pendidik dan tenaga kependidikan, sarana dan prasarana, pengelolaan, pembiayaan, dan penilaian pendidikan.\n\nDengan diraihnya akreditasi A ini, semakin memotivasi seluruh civitas akademika untuk terus meningkatkan kualitas pelayanan pendidikan."],
            ['title' => 'Workshop Pengembangan Kurikulum Merdeka', 'slug' => 'workshop-pengembangan-kurikulum-merdeka', 'category' => 'Kegiatan', 'date' => '2025-06-10', 'is_published' => true, 'views' => 178, 'content' => "Seluruh guru SMA Negeri 1 Jakarta mengikuti workshop pengembangan Kurikulum Merdeka yang diselenggarakan selama dua hari. Workshop ini bertujuan untuk meningkatkan pemahaman dan keterampilan guru dalam mengimplementasikan Kurikulum Merdeka.\n\nNarasumber workshop berasal dari Dinas Pendidikan DKI Jakarta dan praktisi pendidikan yang berpengalaman. Materi yang dibahas meliputi penyusunan modul ajar, asesmen pembelajaran, dan project penguatan profil pelajar Pancasila.\n\nPara guru sangat antusias mengikuti workshop ini dan berkomitmen untuk menerapkan ilmu yang didapat dalam proses pembelajaran di kelas."],
            ['title' => 'Tim Futsal SMAN 1 Jakarta Juarai Turnamen Se-DKI', 'slug' => 'tim-futsal-sman-1-jakarta-juarai-turnamen', 'category' => 'Prestasi', 'date' => '2025-05-28', 'is_published' => true, 'views' => 567, 'content' => "Prestasi gemilang kembali diraih oleh tim futsal SMA Negeri 1 Jakarta. Berhasil menjadi juara 1 turnamen futsal antar SMA se-DKI Jakarta yang diselenggarakan oleh Dispora DKI Jakarta.\n\nPada pertandingan final, tim futsal SMAN 1 Jakarta berhasil mengalahkan SMAN 2 Jakarta dengan skor 3-1. Gol kemenangan dicetak oleh kapten tim, Gilang Ramadhan (kelas XI-A) dan dua gol lainnya oleh Dimas Prayoga (kelas XII-B).\n\nPembina tim futsal, Bapak Dodi Firmansyah, S.Pd., mengaku bangga dengan perjuangan para siswa yang telah berlatih keras selama ini."],
            ['title' => 'Pengumuman Kelulusan Siswa Kelas XII Tahun 2025', 'slug' => 'pengumuman-kelulusan-siswa-kelas-xii-2025', 'category' => 'Pengumuman', 'date' => '2025-05-25', 'is_published' => true, 'views' => 1234, 'content' => "Dengan mengucap syukur kepada Tuhan Yang Maha Esa, SMA Negeri 1 Jakarta mengumumkan kelulusan siswa kelas XII tahun ajaran 2024/2025. Kelulusan tahun ini mencapai 100% dengan nilai yang memuaskan.\n\nSebanyak 240 siswa dinyatakan lulus dan berhak mengikuti wisuda yang akan dilaksanakan pada tanggal 10 Juni 2025 di Aula Sekolah. Sebanyak 85% lulusan diterima di perguruan tinggi negeri melalui jalur SNBP, SNBT, dan jalur mandiri.\n\nSelamat kepada seluruh siswa yang telah lulus. Teruslah berkarya dan mengharumkan nama bangsa."],
            ['title' => 'Kegiatan Bakti Sosial di Panti Asuhan', 'slug' => 'kegiatan-bakti-sosial-di-panti-asuhan', 'category' => 'Kegiatan', 'date' => '2025-04-20', 'is_published' => true, 'views' => 312, 'content' => "OSIS SMA Negeri 1 Jakarta mengadakan kegiatan bakti sosial di Panti Asuhan Kasih Bunda, Jakarta Timur. Kegiatan ini merupakan bagian dari program kerja OSIS bidang sosial.\n\nRombongan yang terdiri dari 30 siswa dan 5 guru pendamping menyerahkan bantuan berupa sembako, alat tulis, dan pakaian layak pakai. Selain itu, siswa juga mengadakan kegiatan belajar bersama dan bermain dengan anak-anak panti.\n\nKegiatan bakti sosial ini bertujuan untuk menumbuhkan rasa kepedulian sosial dan empati siswa terhadap sesama."],
            ['title' => 'Peringatan Hari Pendidikan Nasional 2025', 'slug' => 'peringatan-hari-pendidikan-nasional-2025', 'category' => 'Kegiatan', 'date' => '2025-05-02', 'is_published' => true, 'views' => 198, 'content' => "SMA Negeri 1 Jakarta menggelar upacara peringatan Hari Pendidikan Nasional (Hardiknas) tahun 2025 dengan khidmat. Seluruh siswa, guru, dan karyawan mengikuti upacara di lapangan sekolah.\n\nBertindak sebagai pembina upacara, Kepala SMA Negeri 1 Jakarta membacakan sambutan Menteri Pendidikan yang menekankan pentingnya semangat gotong royong dalam mewujudkan pendidikan yang berkualitas.\n\nSetelah upacara, dilaksanakan berbagai lomba edukatif seperti lomba baca puisi, lomba pidato, dan lomba kebersihan kelas."],
            ['title' => 'Penerimaan Peserta Didik Baru Tahun 2025/2026', 'slug' => 'penerimaan-peserta-didik-baru-2025-2026', 'category' => 'Pengumuman', 'date' => '2025-05-15', 'is_published' => true, 'views' => 2890, 'content' => "SMA Negeri 1 Jakarta membuka penerimaan peserta didik baru (PPDB) untuk tahun ajaran 2025/2026. Pendaftaran dibuka mulai tanggal 1 Juni hingga 30 Juni 2025.\n\nJalur pendaftaran yang tersedia meliputi jalur zonasi (50%), jalur prestasi (30%), jalur afirmasi (15%), dan jalur perpindahan tugas orang tua (5%). Persyaratan dan tata cara pendaftaran dapat dilihat di website resmi sekolah.\n\nBagi calon siswa yang berminat, dapat mengakses portal PPDB DKI Jakarta untuk melakukan pendaftaran secara online."],
            ['title' => 'Kunjungan Edukasi ke Museum Nasional', 'slug' => 'kunjungan-edukasi-ke-museum-nasional', 'category' => 'Kegiatan', 'date' => '2025-03-12', 'is_published' => true, 'views' => 156, 'content' => "Siswa kelas XI jurusan IPS mengadakan kunjungan edukasi ke Museum Nasional Indonesia sebagai bagian dari pembelajaran sejarah. Kegiatan ini diikuti oleh 90 siswa dan 4 guru pendamping.\n\nSelama kunjungan, siswa belajar tentang sejarah Indonesia mulai dari masa prasejarah, kerajaan-kerajaan Nusantara, hingga masa kemerdekaan. Para siswa sangat antusias melihat koleksi-koleksi bersejarah yang ada di museum.\n\nKunjungan edukasi ini diharapkan dapat menambah wawasan siswa dan meningkatkan kecintaan terhadap sejarah dan budaya bangsa."],
            ['title' => 'Sosialisasi Pencegahan Bullying di Sekolah', 'slug' => 'sosialisasi-pencegahan-bullying-di-sekolah', 'category' => 'Kegiatan', 'date' => '2025-03-05', 'is_published' => true, 'views' => 234, 'content' => "SMA Negeri 1 Jakarta mengadakan sosialisasi pencegahan bullying yang bekerja sama dengan Psikolog dari Universitas Indonesia. Kegiatan ini diikuti oleh seluruh siswa dan guru.\n\nMateri sosialisasi meliputi pengertian bullying, jenis-jenis bullying, dampak bullying bagi korban, dan cara mencegah serta menangani bullying di lingkungan sekolah. Pemateri juga memberikan tips bagaimana menjadi teman yang baik dan saling menghargai perbedaan.\n\nDengan sosialisasi ini, diharapkan lingkungan sekolah semakin aman, nyaman, dan bebas dari bullying."],
        ];

        $categoryColors = [
            'Kegiatan' => [41, 128, 185],
            'Prestasi' => [39, 174, 96],
            'Pengumuman' => [243, 156, 18],
        ];

        foreach ($beritas as $i => $data) {
            $data['user_id'] = $adminId;
            $data['published_at'] = Carbon::parse($data['date'] . ' 09:00:00');

            $berita = Berita::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            $filename = 'berita_' . ($i + 1) . '.jpg';
            $fullPath = storage_path("app/public/berita/{$filename}");
            if (!file_exists($fullPath)) {
                $cat = $data['category'];
                $color = $categoryColors[$cat] ?? [52, 73, 94];
                $this->makeImage('berita', $filename, 800, 500, $color, $data['category'], $data['title']);
            }

            if (!$berita->image) {
                $berita->update(['image' => $filename]);
            }
            $this->command->info("  Berita: {$data['title']}");
        }
    }

    protected function seedGaleri(): void
    {
        $galeris = [
            ['title' => 'Upacara Bendera Hari Senin', 'description' => 'Kegiatan upacara bendera setiap hari Senin di lapangan sekolah.', 'category' => 'Kegiatan'],
            ['title' => 'Laboratorium Komputer', 'description' => 'Laboratorium komputer dengan 40 unit PC terbaru.', 'category' => 'Fasilitas'],
            ['title' => 'Perpustakaan Sekolah', 'description' => 'Perpustakaan sekolah yang nyaman dengan koleksi ribuan buku.', 'category' => 'Fasilitas'],
            ['title' => 'Lomba 17 Agustusan', 'description' => 'Perayaan hari kemerdekaan RI dengan berbagai lomba seru.', 'category' => 'Event'],
            ['title' => 'Tim Basket SMAN 1 Jakarta', 'description' => 'Tim basket sekolah saat bertanding di GOR setempat.', 'category' => 'Olahraga'],
            ['title' => 'Lab IPA Terpadu', 'description' => 'Laboratorium IPA untuk praktikum fisika, kimia, dan biologi.', 'category' => 'Fasilitas'],
            ['title' => 'Kegiatan Class Meeting', 'description' => 'Kegiatan class meeting setelah ujian akhir semester.', 'category' => 'Kegiatan'],
            ['title' => 'Musholla Sekolah', 'description' => 'Musholla sekolah yang bersih dan nyaman untuk ibadah.', 'category' => 'Fasilitas'],
            ['title' => 'Pentas Seni Akhir Tahun', 'description' => 'Pentas seni tahunan yang menampilkan bakat dan kreativitas siswa.', 'category' => 'Seni'],
            ['title' => 'Kegiatan Pramuka', 'description' => 'Latihan pramuka rutin setiap hari Sabtu.', 'category' => 'Ekstrakurikuler'],
        ];

        $categoryColors = [
            'Kegiatan' => [41, 128, 185],
            'Fasilitas' => [26, 188, 156],
            'Event' => [243, 156, 18],
            'Olahraga' => [46, 204, 113],
            'Seni' => [155, 89, 182],
            'Ekstrakurikuler' => [230, 126, 34],
        ];

        foreach ($galeris as $i => $data) {
            $galeri = Galeri::firstOrCreate(
                ['title' => $data['title']],
                $data
            );

            $filename = 'galeri_' . ($i + 1) . '.jpg';
            $fullPath = storage_path("app/public/galeri/{$filename}");
            if (!file_exists($fullPath)) {
                $cat = $data['category'];
                $color = $categoryColors[$cat] ?? [52, 73, 94];
                $this->makeImage('galeri', $filename, 800, 600, $color, $data['category'], $data['title']);
            }

            if (!$galeri->image) {
                $galeri->update(['image' => $filename]);
            }
            $this->command->info("  Galeri: {$data['title']}");
        }
    }

    protected function seedFasilitas(): void
    {
        $fasilitas = [
            ['name' => 'Laboratorium Komputer', 'description' => 'Laboratorium komputer dengan 40 unit PC spesifikasi tinggi, koneksi internet cepat, dan AC. Digunakan untuk pembelajaran TIK dan ujian berbasis komputer.', 'status' => 'active'],
            ['name' => 'Laboratorium IPA Terpadu', 'description' => 'Laboratorium IPA terpadu yang dilengkapi alat-alat praktikum fisika, kimia, dan biologi. Tersedia juga alat peraga modern untuk menunjang pembelajaran.', 'status' => 'active'],
            ['name' => 'Perpustakaan', 'description' => 'Perpustakaan sekolah dengan koleksi lebih dari 10.000 buku, termasuk buku pelajaran, fiksi, non-fiksi, ensiklopedia, dan majalah. Tersedia area baca yang nyaman.', 'status' => 'active'],
            ['name' => 'Lapangan Olahraga', 'description' => 'Lapangan olahraga multifungsi yang dapat digunakan untuk sepak bola, basket, voli, futsal, dan atletik. Dilengkapi dengan tribun penonton.', 'status' => 'active'],
            ['name' => 'Musholla', 'description' => 'Musholla sekolah yang bersih, nyaman, dan berkapasitas 200 jamaah. Dilengkapi dengan tempat wudhu yang terpisah untuk putra dan putri.', 'status' => 'active'],
            ['name' => 'Aula Serbaguna', 'description' => 'Aula serbaguna berkapasitas 500 orang dengan panggung, sound system, dan AC. Digunakan untuk rapat, seminar, pentas seni, dan kegiatan lainnya.', 'status' => 'active'],
            ['name' => 'Kantin Sehat', 'description' => 'Kantin sekolah menyediakan makanan dan minuman sehat dan bersih. Kantin dikelola dengan konsep higienis dan ramah lingkungan.', 'status' => 'active'],
            ['name' => 'Ruang Kesenian', 'description' => 'Ruang kesenian yang dilengkapi alat-alat musik, perlengkapan tari, dan ruang latihan teater. Digunakan untuk pengembangan bakat seni siswa.', 'status' => 'active'],
            ['name' => 'Ruang BK', 'description' => 'Ruang Bimbingan Konseling yang nyaman dan nyaman untuk konsultasi siswa. Dilengkapi dengan ruang konseling privat.', 'status' => 'active'],
            ['name' => 'UKS (Unit Kesehatan Sekolah)', 'description' => 'Unit Kesehatan Sekolah yang dilengkapi dengan tempat tidur, obat-obatan, dan peralatan medis dasar. Selalu dijaga oleh petugas kesehatan.', 'status' => 'active'],
        ];

        $colors = [
            [41, 128, 185], [26, 188, 156], [243, 156, 18], [46, 204, 113],
            [155, 89, 182], [230, 126, 34], [52, 73, 94], [231, 76, 60],
            [149, 165, 166], [39, 174, 96],
        ];

        foreach ($fasilitas as $i => $data) {
            $fasilitas = Fasilitas::firstOrCreate(
                ['name' => $data['name']],
                $data
            );

            $filename = 'fasilitas_' . ($i + 1) . '.jpg';
            $fullPath = storage_path("app/public/fasilitas/{$filename}");
            if (!file_exists($fullPath)) {
                $this->makeImage('fasilitas', $filename, 800, 600, $colors[$i], $data['name'], $data['status']);
            }

            if (!$fasilitas->image) {
                $fasilitas->update(['image' => 'fasilitas/' . $filename]);
            }
            $this->command->info("  Fasilitas: {$data['name']}");
        }
    }
}
