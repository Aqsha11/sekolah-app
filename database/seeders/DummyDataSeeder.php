<?php

namespace Database\Seeders;

use App\Models\Absensi;
use App\Models\Agenda;
use App\Models\Alumni;
use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Kontak;
use App\Models\Prestasi;
use App\Models\Banner;
use App\Models\Setting;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSettings();
        $this->seedKelas();
        $this->seedUsers();
        $this->seedGuru();
        $this->seedSiswa();
        $this->seedPrestasi();
        $this->seedBerita();
        $this->seedGaleri();
        $this->seedFasilitas();
        $this->seedKontak();
        $this->seedAgenda();
        $this->seedAlumni();
        $this->seedBanner();
        $this->seedOrangTuaSiswa();
        $this->seedAbsensi();
    }

    protected function seedSettings(): void
    {
        $settings = [
            ['key' => 'nama_sekolah', 'value' => 'SMA Negeri 1 Jakarta'],
            ['key' => 'site_name', 'value' => 'SMAN 1 Jakarta'],
            ['key' => 'school_name', 'value' => 'SMA Negeri 1 Jakarta'],
            ['key' => 'alamat', 'value' => 'Jl. Budi Utomo No. 7, Jakarta Pusat'],
            ['key' => 'telepon', 'value' => '(021) 3456789'],
            ['key' => 'email', 'value' => 'info@sman1jakarta.sch.id'],
            ['key' => 'website', 'value' => 'https://sman1jakarta.sch.id'],
            ['key' => 'kepala_sekolah', 'value' => 'Dr. H. Ahmad Fauzi, M.Pd.'],
            ['key' => 'nama_kepsek', 'value' => 'Dr. H. Ahmad Fauzi, M.Pd.'],
            ['key' => 'npsn', 'value' => '20100234'],
            ['key' => 'akreditasi', 'value' => 'A'],
            ['key' => 'visi', 'value' => 'Mewujudkan sekolah unggul yang menghasilkan lulusan beriman, berilmu, dan berkarakter Pancasila.'],
            ['key' => 'misi', 'value' => '1. Menumbuhkan penghayatan dan pengamalan ajaran agama. 2. Mengembangkan potensi akademik dan non-akademik siswa. 3. Membentuk karakter siswa yang disiplin, jujur, dan bertanggung jawab.'],
            ['key' => 'tentang_sekolah', 'value' => 'SMA Negeri 1 Jakarta merupakan salah satu sekolah menengah atas negeri tertua dan terbaik di Jakarta. Berdiri sejak tahun 1950, sekolah ini telah melahirkan ribuan lulusan yang berkiprah di berbagai bidang di tingkat nasional maupun internasional.'],
            ['key' => 'hero_title', 'value' => 'SMA Negeri 1 Jakarta'],
            ['key' => 'hero_description', 'value' => 'Mewujudkan generasi berkarakter, disiplin, unggul, dan berwawasan global.'],
            ['key' => 'profil_sekolah', 'value' => 'SMA Negeri 1 Jakarta merupakan sekolah menengah atas negeri yang berlokasi di Jakarta Pusat. Berdiri sejak tahun 1950, sekolah ini telah melahirkan ribuan lulusan yang berkiprah di berbagai bidang di tingkat nasional maupun internasional.'],
            ['key' => 'sambutan_kepsek', 'value' => 'Assalamualaikum wr. wb. Puji syukur kehadirat Allah SWT atas limpahan rahmat dan karunia-Nya. SMA Negeri 1 Jakarta terus berkomitmen untuk memberikan pendidikan terbaik bagi generasi penerus bangsa. Dengan dukungan tenaga pendidik yang profesional dan fasilitas yang memadai, kami siap mencetak lulusan yang beriman, berilmu, dan berkarakter.'],
            ['key' => 'sejarah', 'value' => 'SMA Negeri 1 Jakarta didirikan pada tahun 1950 dengan nama SMA Negeri 1 Jakarta Pusat. Sejak awal berdiri, sekolah ini telah menjadi salah satu sekolah favorit di Jakarta. Berbagai prestasi telah diraih baik di tingkat kota, provinsi, maupun nasional.'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }

        $this->generatePlaceholderImages();

        $this->command->info('Settings berhasil dibuat.');
    }

    protected function generatePlaceholderImages(): void
    {
        $placeholder = base64_decode(
            '/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAgGBgcGBQgHBwcJCQgKDBQNDAsLDBkSEw8UHRofHh0aHBwgJC4nICIsIxwcKDcpLDAxNDQ0Hyc5PTgyPC4zNDL/2wBDAQkJCQwLDBgNDRgyIRwhMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjL/wAARCAABAAEDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYI4Q/SFhSRFJiMkVic4EzQjR0RSlFNkVUcCZS/9oADAMBAAIRAxEAPwC1//Z'
        );

        $dirs = ['settings', 'banners'];
        foreach ($dirs as $dir) {
            $path = storage_path("app/public/{$dir}");
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
        }

        $files = [
            'settings/hero_placeholder.jpg',
            'settings/profil_placeholder.jpg',
            'banners/banner1.jpg',
            'banners/banner2.jpg',
            'banners/banner3.jpg',
        ];

        foreach ($files as $file) {
            $filepath = storage_path("app/public/{$file}");
            if (!file_exists($filepath)) {
                file_put_contents($filepath, $placeholder);
            }
        }

        Setting::updateOrCreate(['key' => 'hero_image'], ['value' => 'hero_placeholder.jpg']);
        Setting::updateOrCreate(['key' => 'profil_image'], ['value' => 'profil_placeholder.jpg']);
    }

    protected function seedKelas(): void
    {
        $kelas = [];
        $tingkat = ['X', 'XI', 'XII'];
        $jurusan = ['A', 'B', 'C'];

        foreach ($tingkat as $t) {
            foreach ($jurusan as $j) {
                $kelas[] = ['nama_kelas' => "{$t}-{$j}"];
            }
        }

        foreach ($kelas as $k) {
            Kelas::create($k);
        }

        $this->command->info('Kelas berhasil dibuat.');
    }

    protected function seedUsers(): void
    {
        $users = [
            [
                'name' => 'Dr. H. Ahmad Fauzi, M.Pd.',
                'email' => 'kepalasekolah@sekolah.test',
                'role' => 'admin',
            ],
            [
                'name' => 'Rina Marlina, S.Pd.',
                'email' => 'guru1@sekolah.test',
                'role' => 'guru',
            ],
            [
                'name' => 'Bambang Supriyadi, S.Pd.',
                'email' => 'guru2@sekolah.test',
                'role' => 'guru',
            ],
            [
                'name' => 'Dewi Sartika, S.Pd.',
                'email' => 'guru3@sekolah.test',
                'role' => 'guru',
            ],
            [
                'name' => 'Hendra Kusuma, S.Pd.',
                'email' => 'guru4@sekolah.test',
                'role' => 'guru',
            ],
            [
                'name' => 'Siti Rahmawati, S.Pd.',
                'email' => 'guru5@sekolah.test',
                'role' => 'guru',
            ],
            [
                'name' => 'Editor Berita',
                'email' => 'editor@sekolah.test',
                'role' => 'editor',
            ],
        ];

        foreach ($users as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'is_active' => true,
                ]
            );
            $user->syncRoles([$userData['role']]);
        }

        // Create Orang Tua users (untuk login) + OrangTua records (untuk data)
        $orangTuaData = [
            ['name' => 'Budi Santoso', 'email' => 'budi.ortu@sekolah.test', 'phone' => '082116052300'],
            ['name' => 'Siti Rahmawati', 'email' => 'siti.ortu@sekolah.test', 'phone' => '082116052301'],
            ['name' => 'Ahmad Hidayat', 'email' => 'ahmad.ortu@sekolah.test', 'phone' => '082116052302'],
            ['name' => 'Dewi Sartika', 'email' => 'dewi.ortu@sekolah.test', 'phone' => '082116052303'],
            ['name' => 'Hendra Gunawan', 'email' => 'hendra.ortu@sekolah.test', 'phone' => '082116052304'],
        ];

        foreach ($orangTuaData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'phone' => $data['phone'],
                    'is_active' => true,
                ]
            );
            $user->syncRoles(['orang_tua']);

            OrangTua::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['name'],
                    'phone' => $data['phone'],
                ]
            );
        }

        $this->command->info('Users berhasil dibuat.');
    }

    protected function seedGuru(): void
    {
        $gurus = [
            [
                'name' => 'Dr. H. Ahmad Fauzi, M.Pd.',
                'nip' => '196501011990031005',
                'subject' => '-',
                'position' => 'Kepala Sekolah',
                'email' => 'kepalasekolah@sekolah.test',
                'phone' => '081211111111',
                'bio' => 'Kepala sekolah berpengalaman dengan visi pendidikan yang kuat.',
                'is_active' => true,
            ],
            [
                'name' => 'Rina Marlina, S.Pd.',
                'nip' => '197203151998042006',
                'subject' => 'Matematika',
                'position' => 'Guru Mata Pelajaran',
                'email' => 'rina.marlina@sekolah.test',
                'phone' => '081211111112',
                'bio' => 'Guru matematika yang inovatif dan menyenangkan.',
                'is_active' => true,
            ],
            [
                'name' => 'Bambang Supriyadi, S.Pd.',
                'nip' => '197506202001121004',
                'subject' => 'Bahasa Indonesia',
                'position' => 'Guru Mata Pelajaran',
                'email' => 'bambang.supriyadi@sekolah.test',
                'phone' => '081211111113',
                'bio' => 'Guru bahasa Indonesia yang aktif dalam kegiatan literasi sekolah.',
                'is_active' => true,
            ],
            [
                'name' => 'Dewi Sartika, S.Pd.',
                'nip' => '198012052005012008',
                'subject' => 'Bahasa Inggris',
                'position' => 'Guru Mata Pelajaran',
                'email' => 'dewi.sartika@sekolah.test',
                'phone' => '081211111114',
                'bio' => 'Guru bahasa Inggris dengan pengalaman mengajar IELTS.',
                'is_active' => true,
            ],
            [
                'name' => 'Hendra Kusuma, S.Pd.',
                'nip' => '198203102006041010',
                'subject' => 'Fisika',
                'position' => 'Kepala Laboratorium',
                'email' => 'hendra.kusuma@sekolah.test',
                'phone' => '081211111115',
                'bio' => 'Guru fisika yang aktif dalam penelitian dan lomba sains.',
                'is_active' => true,
            ],
            [
                'name' => 'Siti Rahmawati, S.Pd.',
                'nip' => '198307122007012012',
                'subject' => 'Kimia',
                'position' => 'Guru Mata Pelajaran',
                'email' => 'siti.rahmawati@sekolah.test',
                'phone' => '081211111116',
                'bio' => 'Guru kimia dengan metode pembelajaran praktik yang interaktif.',
                'is_active' => true,
            ],
            [
                'name' => 'Agus Wijaya, S.Pd.',
                'nip' => '198408152008031011',
                'subject' => 'Biologi',
                'position' => 'Guru Mata Pelajaran',
                'email' => 'agus.wijaya@sekolah.test',
                'phone' => '081211111117',
                'bio' => 'Guru biologi yang gemar mengadakan penelitian lapangan.',
                'is_active' => true,
            ],
            [
                'name' => 'Fitriani, S.Pd.',
                'nip' => '198505202009042009',
                'subject' => 'Sejarah',
                'position' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'email' => 'fitriani@sekolah.test',
                'phone' => '081211111118',
                'bio' => 'Guru sejarah yang aktif dalam pengembangan kurikulum.',
                'is_active' => true,
            ],
            [
                'name' => 'Dodi Firmansyah, S.Pd.',
                'nip' => '198606252010011013',
                'subject' => 'Penjaskes',
                'position' => 'Pembina Ekstrakurikuler',
                'email' => 'dodi.firmansyah@sekolah.test',
                'phone' => '081211111119',
                'bio' => 'Pelatih tim basket dan futsal sekolah.',
                'is_active' => true,
            ],
            [
                'name' => 'Nurul Hidayah, S.Pd.',
                'nip' => '198707302011012014',
                'subject' => 'BK',
                'position' => 'Guru Bimbingan Konseling',
                'email' => 'nurul.hidayah@sekolah.test',
                'phone' => '081211111120',
                'bio' => 'Konselor yang peduli dengan perkembangan mental siswa.',
                'is_active' => true,
            ],
            [
                'name' => 'Eko Prasetyo, S.Kom.',
                'nip' => '198808052012011015',
                'subject' => 'Informatika/TIK',
                'position' => 'Kepala Laboratorium Komputer',
                'email' => 'eko.prasetyo@sekolah.test',
                'phone' => '081211111121',
                'bio' => 'Guru TIK yang ahli dalam pengembangan sistem informasi sekolah.',
                'is_active' => true,
            ],
            [
                'name' => 'Ani Susilowati, S.Pd.',
                'nip' => '198909102013022016',
                'subject' => 'Seni Budaya',
                'position' => 'Pembina Ekstrakurikuler',
                'email' => 'ani.susilowati@sekolah.test',
                'phone' => '081211111122',
                'bio' => 'Pembina paduan suara dan seni tari sekolah.',
                'is_active' => true,
            ],
        ];

        foreach ($gurus as $guru) {
            Guru::firstOrCreate(
                ['nip' => $guru['nip']],
                $guru
            );
        }

        $this->command->info('Guru berhasil dibuat.');
    }

    protected function seedSiswa(): void
    {
        $namaSiswa = [
            'Ahmad Fauzan',
            'Bunga Citra Lestari',
            'Chandra Wijaya',
            'Dian Permata Sari',
            'Eko Prasetyo',
            'Fitri Handayani',
            'Gilang Ramadhan',
            'Hesti Purnamasari',
            'Indra Maulana',
            'Joko Susilo',
            'Kartika Sari Dewi',
            'Lukman Hakim',
            'Mega Wati',
            'Nanda Pratama',
            'Olivia Putri',
            'Panji Kusuma',
            'Rina Melati',
            'Satria Budi',
            'Tika Wulandari',
            'Umar Hadi',
            'Vina Amalia',
            'Wahyu Nugroho',
            'Yuniarti',
            'Zaki Abdullah',
            'Aditya Rahman',
            'Bella Safira',
            'Cipto Gunawan',
            'Dina Mariana',
            'Evan Dimas',
            'Fara Nabila',
            'Guntur Prayoga',
            'Happy Novita',
            'Iqbal Ramadhan',
            'Jessica Angelina',
            'Kevin Sanjaya',
            'Laras Ayu',
            'M. Rizky Pratama',
            'Natasha Kusuma',
            'Oscar Wirawan',
            'Putri Ayunda',
            'Rafi Ahmad',
            'Salsabila Nur',
            'Taufik Hidayat',
            'Utami Dewi',
            'Valentino Febri',
            'Widya Astuti',
            'Xavier Januar',
            'Yoga Saputra',
            'Zahra Aliffia',
            'Adi Saputra',
            'Bima Sakti',
            'Citra Kirana',
            'Dimas Prayoga',
            'Elsa Safitri',
            'Fajar Setiawan',
            'Gita Permata',
            'Hasan Basri',
            'Intan Permata',
            'Jefri Pratama',
            'Kinanti Ayu',
            'Lintang Kusuma',
            'Maya Sari',
            'Novi Andriani',
            'Oni Kurniawan',
            'Puspita Dewi',
            'Rizky Febian',
            'Sherly Anggraini',
            'Teguh Santoso',
            'Ucok Sihombing',
            'Vanesa Gracia',
            'Winda Sari',
            'Yudha Pratama',
        ];

        $kelasList = ['X-A', 'X-B', 'X-C', 'XI-A', 'XI-B', 'XI-C', 'XII-A', 'XII-B', 'XII-C'];
        $jurusanList = ['IPA', 'IPA', 'IPA', 'IPA', 'IPS', 'IPS', 'IPA', 'IPS', 'Bahasa'];

        foreach ($namaSiswa as $index => $nama) {
            $kelasIndex = $index % count($kelasList);
            Siswa::create([
                'nama' => $nama,
                'nis' => '2024' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'kelas' => $kelasList[$kelasIndex],
                'jurusan' => $jurusanList[$kelasIndex],
                'rfid' => 'RFID' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
            ]);
        }

        $this->command->info('Siswa berhasil dibuat.');
    }

    protected function seedPrestasi(): void
    {
        $prestasis = [
            [
                'title' => 'Juara 1 Olimpiade Matematika Tingkat Nasional',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'year' => '2025',
                'description' => 'Siswa kami berhasil meraih juara 1 Olimpiade Matematika yang diselenggarakan oleh Kementerian Pendidikan.',
            ],
            [
                'title' => 'Juara 2 Lomba Debat Bahasa Inggris',
                'category' => 'Akademik',
                'level' => 'Provinsi',
                'year' => '2025',
                'description' => 'Tim debat bahasa Inggris berhasil meraih juara 2 tingkat provinsi DKI Jakarta.',
            ],
            [
                'title' => 'Juara 1 Lomba Pidato Bahasa Indonesia',
                'category' => 'Akademik',
                'level' => 'Kota',
                'year' => '2025',
                'description' => 'Prestasi membanggakan dalam lomba pidato tingkat kota.',
            ],
            [
                'title' => 'Juara 3 Olimpiade Sains Nasional (Fisika)',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'year' => '2024',
                'description' => 'Meraih medali perunggu Olimpiade Sains Nasional bidang Fisika.',
            ],
            [
                'title' => 'Juara 1 Turnamen Futsal Antar Sekolah',
                'category' => 'Olahraga',
                'level' => 'Kota',
                'year' => '2025',
                'description' => 'Tim futsal sekolah berhasil menjadi juara 1 turnamen futsal se-DKI Jakarta.',
            ],
            [
                'title' => 'Juara 2 Lomba Band Pelajar',
                'category' => 'Seni',
                'level' => 'Provinsi',
                'year' => '2025',
                'description' => 'Band sekolah meraih juara 2 lomba band pelajar tingkat provinsi.',
            ],
            [
                'title' => 'Juara 1 Lomba Tari Tradisional',
                'category' => 'Seni',
                'level' => 'Nasional',
                'year' => '2024',
                'description' => 'Siswa meraih juara 1 lomba tari tradisional tingkat nasional.',
            ],
            [
                'title' => 'Juara Harapan 1 Olimpiade Kimia',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'year' => '2024',
                'description' => 'Prestasi membanggakan di Olimpiade Kimia Nasional.',
            ],
            [
                'title' => 'Juara 3 Lomba Cipta Puisi',
                'category' => 'Seni',
                'level' => 'Provinsi',
                'year' => '2025',
                'description' => 'Siswa berhasil meraih juara 3 lomba cipta puisi tingkat provinsi.',
            ],
            [
                'title' => 'Juara 1 Lomba Mading',
                'category' => 'Seni',
                'level' => 'Kota',
                'year' => '2025',
                'description' => 'Majalah dinding sekolah meraih juara 1 lomba mading tingkat kota.',
            ],
            [
                'title' => 'Juara 2 Lomba Cerdas Cermat Sejarah',
                'category' => 'Akademik',
                'level' => 'Provinsi',
                'year' => '2024',
                'description' => 'Tim cerdas cermat meraih juara 2 tingkat provinsi.',
            ],
            [
                'title' => 'Juara 1 Pencak Silat Tingkat Nasional',
                'category' => 'Olahraga',
                'level' => 'Nasional',
                'year' => '2025',
                'description' => 'Siswa meraih juara 1 pencak silat kategori putra tingkat nasional.',
            ],
        ];

        foreach ($prestasis as $prestasi) {
            Prestasi::create($prestasi);
        }

        $this->command->info('Prestasi berhasil dibuat.');
    }

    protected function seedBerita(): void
    {
        $beritas = [
            [
                'title' => 'Kegiatan MPLS Tahun Ajaran 2025/2026 Berjalan Lancar',
                'slug' => 'kegiatan-mpls-tahun-ajaran-2025-2026',
                'content' => "Masa Pengenalan Lingkungan Sekolah (MPLS) tahun ajaran 2025/2026 telah berlangsung dengan sukses selama tiga hari. Kegiatan ini diikuti oleh seluruh siswa baru kelas X dengan antusiasme yang tinggi.\n\nBerbagai kegiatan telah dilaksanakan, mulai dari pengenalan fasilitas sekolah, perkenalan dengan guru dan karyawan, hingga berbagai games edukatif yang bertujuan untuk mempererat kebersamaan antar siswa baru.\n\nKepala SMA Negeri 1 Jakarta, Dr. H. Ahmad Fauzi, M.Pd., dalam sambutannya menyampaikan bahwa MPLS bukan hanya sekedar pengenalan lingkungan, tetapi juga awal dari perjalanan siswa dalam menuntut ilmu di sekolah ini.",
                'category' => 'Kegiatan',
                'date' => '2025-07-15',
                'published_at' => '2025-07-15 09:00:00',
                'is_published' => true,
                'user_id' => 1,
                'views' => 245,
            ],
            [
                'title' => 'SMA Negeri 1 Jakarta Meraih Akreditasi A',
                'slug' => 'sma-negeri-1-jakarta-meraih-akreditasi-a',
                'content' => "SMA Negeri 1 Jakarta berhasil meraih akreditasi A (Unggul) dari Badan Akreditasi Nasional Sekolah/Madrasah (BAN-SM). Pencapaian ini menunjukkan kualitas pendidikan yang terus meningkat.\n\nProses akreditasi meliputi penilaian terhadap delapan standar nasional pendidikan, yaitu standar isi, proses, kompetensi lulusan, pendidik dan tenaga kependidikan, sarana dan prasarana, pengelolaan, pembiayaan, dan penilaian pendidikan.\n\nDengan diraihnya akreditasi A ini, semakin memotivasi seluruh civitas akademika untuk terus meningkatkan kualitas pelayanan pendidikan.",
                'category' => 'Prestasi',
                'date' => '2025-06-20',
                'published_at' => '2025-06-20 10:30:00',
                'is_published' => true,
                'user_id' => 1,
                'views' => 389,
            ],
            [
                'title' => 'Workshop Pengembangan Kurikulum Merdeka',
                'slug' => 'workshop-pengembangan-kurikulum-merdeka',
                'content' => "Seluruh guru SMA Negeri 1 Jakarta mengikuti workshop pengembangan Kurikulum Merdeka yang diselenggarakan selama dua hari. Workshop ini bertujuan untuk meningkatkan pemahaman dan keterampilan guru dalam mengimplementasikan Kurikulum Merdeka.\n\nNarasumber workshop berasal dari Dinas Pendidikan DKI Jakarta dan praktisi pendidikan yang berpengalaman. Materi yang dibahas meliputi penyusunan modul ajar, asesmen pembelajaran, dan project penguatan profil pelajar Pancasila.\n\nPara guru sangat antusias mengikuti workshop ini dan berkomitmen untuk menerapkan ilmu yang didapat dalam proses pembelajaran di kelas.",
                'category' => 'Kegiatan',
                'date' => '2025-06-10',
                'published_at' => '2025-06-10 08:00:00',
                'is_published' => true,
                'user_id' => 2,
                'views' => 178,
            ],
            [
                'title' => 'Tim Futsal SMAN 1 Jakarta Juarai Turnamen Se-DKI',
                'slug' => 'tim-futsal-sman-1-jakarta-juarai-turnamen',
                'content' => "Prestasi gemilang kembali diraih oleh tim futsal SMA Negeri 1 Jakarta. Berhasil menjadi juara 1 turnamen futsal antar SMA se-DKI Jakarta yang diselenggarakan oleh Dispora DKI Jakarta.\n\nPada pertandingan final, tim futsal SMAN 1 Jakarta berhasil mengalahkan SMAN 2 Jakarta dengan skor 3-1. Gol kemenangan dicetak oleh kapten tim, Gilang Ramadhan (kelas XI-A) dan dua gol lainnya oleh Dimas Prayoga (kelas XII-B).\n\nPembina tim futsal, Bapak Dodi Firmansyah, S.Pd., mengaku bangga dengan perjuangan para siswa yang telah berlatih keras selama ini.",
                'category' => 'Prestasi',
                'date' => '2025-05-28',
                'published_at' => '2025-05-28 14:00:00',
                'is_published' => true,
                'user_id' => 3,
                'views' => 567,
            ],
            [
                'title' => 'Pengumuman Kelulusan Siswa Kelas XII Tahun 2025',
                'slug' => 'pengumuman-kelulusan-siswa-kelas-xii-2025',
                'content' => "Dengan mengucap syukur kepada Tuhan Yang Maha Esa, SMA Negeri 1 Jakarta mengumumkan kelulusan siswa kelas XII tahun ajaran 2024/2025. Kelulusan tahun ini mencapai 100% dengan nilai yang memuaskan.\n\nSebanyak 240 siswa dinyatakan lulus dan berhak mengikuti wisuda yang akan dilaksanakan pada tanggal 10 Juni 2025 di Aula Sekolah. Sebanyak 85% lulusan diterima di perguruan tinggi negeri melalui jalur SNBP, SNBT, dan jalur mandiri.\n\nSelamat kepada seluruh siswa yang telah lulus. Teruslah berkarya dan mengharumkan nama bangsa.",
                'category' => 'Pengumuman',
                'date' => '2025-05-25',
                'published_at' => '2025-05-25 09:00:00',
                'is_published' => true,
                'user_id' => 1,
                'views' => 1234,
            ],
            [
                'title' => 'Kegiatan Bakti Sosial di Panti Asuhan',
                'slug' => 'kegiatan-bakti-sosial-di-panti-asuhan',
                'content' => "OSIS SMA Negeri 1 Jakarta mengadakan kegiatan bakti sosial di Panti Asuhan Kasih Bunda, Jakarta Timur. Kegiatan ini merupakan bagian dari program kerja OSIS bidang sosial.\n\nRombongan yang terdiri dari 30 siswa dan 5 guru pendamping menyerahkan bantuan berupa sembako, alat tulis, dan pakaian layak pakai. Selain itu, siswa juga mengadakan kegiatan belajar bersama dan bermain dengan anak-anak panti.\n\nKegiatan bakti sosial ini bertujuan untuk menumbuhkan rasa kepedulian sosial dan empati siswa terhadap sesama.",
                'category' => 'Kegiatan',
                'date' => '2025-04-20',
                'published_at' => '2025-04-20 11:00:00',
                'is_published' => true,
                'user_id' => 4,
                'views' => 312,
            ],
            [
                'title' => 'Peringatan Hari Pendidikan Nasional 2025',
                'slug' => 'peringatan-hari-pendidikan-nasional-2025',
                'content' => "SMA Negeri 1 Jakarta menggelar upacara peringatan Hari Pendidikan Nasional (Hardiknas) tahun 2025 dengan khidmat. Seluruh siswa, guru, dan karyawan mengikuti upacara di lapangan sekolah.\n\nBertindak sebagai pembina upacara, Kepala SMA Negeri 1 Jakarta membacakan sambutan Menteri Pendidikan yang menekankan pentingnya semangat gotong royong dalam mewujudkan pendidikan yang berkualitas.\n\nSetelah upacara, dilaksanakan berbagai lomba edukatif seperti lomba baca puisi, lomba pidato, dan lomba kebersihan kelas.",
                'category' => 'Kegiatan',
                'date' => '2025-05-02',
                'published_at' => '2025-05-02 10:00:00',
                'is_published' => true,
                'user_id' => 2,
                'views' => 198,
            ],
            [
                'title' => 'Penerimaan Peserta Didik Baru Tahun 2025/2026',
                'slug' => 'penerimaan-peserta-didik-baru-2025-2026',
                'content' => "SMA Negeri 1 Jakarta membuka penerimaan peserta didik baru (PPDB) untuk tahun ajaran 2025/2026. Pendaftaran dibuka mulai tanggal 1 Juni hingga 30 Juni 2025.\n\nJalur pendaftaran yang tersedia meliputi jalur zonasi (50%), jalur prestasi (30%), jalur afirmasi (15%), dan jalur perpindahan tugas orang tua (5%). Persyaratan dan tata cara pendaftaran dapat dilihat di website resmi sekolah.\n\nBagi calon siswa yang berminat, dapat mengakses portal PPDB DKI Jakarta untuk melakukan pendaftaran secara online.",
                'category' => 'Pengumuman',
                'date' => '2025-05-15',
                'published_at' => '2025-05-15 08:30:00',
                'is_published' => true,
                'user_id' => 1,
                'views' => 2890,
            ],
            [
                'title' => 'Kunjungan Edukasi ke Museum Nasional',
                'slug' => 'kunjungan-edukasi-ke-museum-nasional',
                'content' => "Siswa kelas XI jurusan IPS mengadakan kunjungan edukasi ke Museum Nasional Indonesia sebagai bagian dari pembelajaran sejarah. Kegiatan ini diikuti oleh 90 siswa dan 4 guru pendamping.\n\nSelama kunjungan, siswa belajar tentang sejarah Indonesia mulai dari masa prasejarah, kerajaan-kerajaan Nusantara, hingga masa kemerdekaan. Para siswa sangat antusias melihat koleksi-koleksi bersejarah yang ada di museum.\n\nKunjungan edukasi ini diharapkan dapat menambah wawasan siswa dan meningkatkan kecintaan terhadap sejarah dan budaya bangsa.",
                'category' => 'Kegiatan',
                'date' => '2025-03-12',
                'published_at' => '2025-03-12 13:00:00',
                'is_published' => true,
                'user_id' => 5,
                'views' => 156,
            ],
            [
                'title' => 'Sosialisasi Pencegahan Bullying di Sekolah',
                'slug' => 'sosialisasi-pencegahan-bullying-di-sekolah',
                'content' => "SMA Negeri 1 Jakarta mengadakan sosialisasi pencegahan bullying yang bekerja sama dengan Psikolog dari Universitas Indonesia. Kegiatan ini diikuti oleh seluruh siswa dan guru.\n\nMateri sosialisasi meliputi pengertian bullying, jenis-jenis bullying, dampak bullying bagi korban, dan cara mencegah serta menangani bullying di lingkungan sekolah. Pemateri juga memberikan tips bagaimana menjadi teman yang baik dan saling menghargai perbedaan.\n\nDengan sosialisasi ini, diharapkan lingkungan sekolah semakin aman, nyaman, dan bebas dari bullying.",
                'category' => 'Kegiatan',
                'date' => '2025-03-05',
                'published_at' => '2025-03-05 09:30:00',
                'is_published' => true,
                'user_id' => 3,
                'views' => 234,
            ],
        ];

        foreach ($beritas as $berita) {
            Berita::create($berita);
        }

        $this->command->info('Berita berhasil dibuat.');
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

        foreach ($galeris as $galeri) {
            Galeri::create($galeri);
        }

        $this->command->info('Galeri berhasil dibuat.');
    }

    protected function seedFasilitas(): void
    {
        $fasilitas = [
            [
                'name' => 'Laboratorium Komputer',
                'description' => 'Laboratorium komputer dengan 40 unit PC spesifikasi tinggi, koneksi internet cepat, dan AC. Digunakan untuk pembelajaran TIK dan ujian berbasis komputer.',
                'status' => 'active',
            ],
            [
                'name' => 'Laboratorium IPA Terpadu',
                'description' => 'Laboratorium IPA terpadu yang dilengkapi alat-alat praktikum fisika, kimia, dan biologi. Tersedia juga alat peraga modern untuk menunjang pembelajaran.',
                'status' => 'active',
            ],
            [
                'name' => 'Perpustakaan',
                'description' => 'Perpustakaan sekolah dengan koleksi lebih dari 10.000 buku, termasuk buku pelajaran, fiksi, non-fiksi, ensiklopedia, dan majalah. Tersedia area baca yang nyaman.',
                'status' => 'active',
            ],
            [
                'name' => 'Lapangan Olahraga',
                'description' => 'Lapangan olahraga multifungsi yang dapat digunakan untuk sepak bola, basket, voli, futsal, dan atletik. Dilengkapi dengan tribun penonton.',
                'status' => 'active',
            ],
            [
                'name' => 'Musholla',
                'description' => 'Musholla sekolah yang bersih, nyaman, dan berkapasitas 200 jamaah. Dilengkapi dengan tempat wudhu yang terpisah untuk putra dan putri.',
                'status' => 'active',
            ],
            [
                'name' => 'Aula Serbaguna',
                'description' => 'Aula serbaguna berkapasitas 500 orang dengan panggung, sound system, dan AC. Digunakan untuk rapat, seminar, pentas seni, dan kegiatan lainnya.',
                'status' => 'active',
            ],
            [
                'name' => 'Kantin Sehat',
                'description' => 'Kantin sekolah menyediakan makanan dan minuman sehat dan bersih. Kantin dikelola dengan konsep higienis dan ramah lingkungan.',
                'status' => 'active',
            ],
            [
                'name' => 'Ruang Kesenian',
                'description' => 'Ruang kesenian yang dilengkapi alat-alat musik, perlengkapan tari, dan ruang latihan teater. Digunakan untuk pengembangan bakat seni siswa.',
                'status' => 'active',
            ],
            [
                'name' => 'Ruang BK',
                'description' => 'Ruang Bimbingan Konseling yang nyaman dan nyaman untuk konsultasi siswa. Dilengkapi dengan ruang konseling privat.',
                'status' => 'active',
            ],
            [
                'name' => 'UKS (Unit Kesehatan Sekolah)',
                'description' => 'Unit Kesehatan Sekolah yang dilengkapi dengan tempat tidur, obat-obatan, dan peralatan medis dasar. Selalu dijaga oleh petugas kesehatan.',
                'status' => 'active',
            ],
            [
                'name' => 'Laboratorium Bahasa',
                'description' => 'Laboratorium bahasa dengan 30 unit komputer dan headset untuk pembelajaran bahasa asing interaktif.',
                'status' => 'inactive',
            ],
            [
                'name' => 'Ruang OSIS',
                'description' => 'Ruang sekretariat OSIS yang digunakan untuk rapat, diskusi, dan kegiatan organisasi siswa.',
                'status' => 'active',
            ],
        ];

        foreach ($fasilitas as $f) {
            Fasilitas::create($f);
        }

        $this->command->info('Fasilitas berhasil dibuat.');
    }

    protected function seedKontak(): void
    {
        $kontaks = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081298765432',
                'subject' => 'Informasi PPDB',
                'message' => 'Selamat siang, saya ingin bertanya mengenai jadwal pendaftaran PPDB untuk tahun ajaran 2025/2026. Apakah masih dibuka? Terima kasih.',
                'status' => 'replied',
                'reply_message' => 'Selamat siang, terima kasih telah menghubungi SMA Negeri 1 Jakarta. PPDB tahun ajaran 2025/2026 masih dibuka hingga 30 Juni 2025. Silakan kunjungi website resmi sekolah untuk informasi lebih lanjut.',
                'replied_by' => 1,
                'replied_at' => '2025-06-01 10:30:00',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'phone' => '081234567890',
                'subject' => 'Permohonan Informasi Beasiswa',
                'message' => 'Dengan hormat, saya ingin menanyakan apakah ada program beasiswa untuk siswa berprestasi di SMA Negeri 1 Jakarta? Mohon informasinya. Terima kasih.',
                'status' => 'read',
            ],
            [
                'name' => 'Ahmad Dhani',
                'email' => 'ahmad.dhani@email.com',
                'phone' => '087812345678',
                'subject' => 'Saran dan Masukan',
                'message' => 'Saya sebagai orang tua siswa kelas X-A ingin memberikan saran agar sekolah menambah jam pelajaran bahasa Inggris untuk persiapan TOEFL. Terima kasih atas perhatiannya.',
                'status' => 'unread',
            ],
            [
                'name' => 'Rina Wijaya',
                'email' => 'rina.wijaya@email.com',
                'phone' => '085611223344',
                'subject' => 'Kehilangan Dokumen Ijazah',
                'message' => 'Selamat pagi, saya alumni tahun 2020. Saya kehilangan ijazah dan ingin menanyakan prosedur pengurusan ijazah pengganti. Mohon bantuannya.',
                'status' => 'replied',
                'reply_message' => 'Selamat pagi, untuk pengurusan ijazah pengganti, silakan datang ke sekolah dengan membawa fotokopi KTP, pas foto 3x4, dan surat kehilangan dari kepolisian. Terima kasih.',
                'replied_by' => 2,
                'replied_at' => '2025-06-02 09:15:00',
            ],
            [
                'name' => 'Doni Prasetyo',
                'email' => 'doni.prasetyo@email.com',
                'phone' => '082134567890',
                'subject' => 'Kerjasama Kegiatan Ekstrakurikuler',
                'message' => 'Saya dari klub robotik Universitas Indonesia ingin menawarkan kerjasama pelatihan robotik untuk siswa SMA Negeri 1 Jakarta. Mohon info lebih lanjut mengenai pihak yang dapat dihubungi.',
                'status' => 'unread',
            ],
            [
                'name' => 'Maya Anggraini',
                'email' => 'maya.anggraini@email.com',
                'phone' => '081345678901',
                'subject' => 'Pertanyaan Jadwal Ujian',
                'message' => 'Mohon informasi jadwal ujian akhir semester genap tahun 2025. Apakah sudah ada jadwal resminya? Terima kasih.',
                'status' => 'read',
            ],
            [
                'name' => 'Hendra Gunawan',
                'email' => 'hendra.gunawan@email.com',
                'phone' => '081567890123',
                'subject' => 'Laporan Kerusakan Fasilitas',
                'message' => 'Selamat siang, saya melihat ada beberapa kerusakan di lapangan basket sekolah seperti ring yang sudah longgar. Mohon segera diperbaiki demi keamanan siswa.',
                'status' => 'replied',
                'reply_message' => 'Selamat siang, terima kasih atas laporannya. Kami akan segera menindaklanjuti perbaikan fasilitas lapangan basket. Terima kasih atas perhatiannya.',
                'replied_by' => 1,
                'replied_at' => '2025-06-05 13:00:00',
            ],
        ];

        foreach ($kontaks as $kontak) {
            Kontak::create($kontak);
        }

        $this->command->info('Kontak berhasil dibuat.');
    }

    protected function seedAgenda(): void
    {
        $agendas = [
            [
                'judul' => 'Upacara Bendera Hari Senin',
                'tanggal' => '2026-06-15',
                'deskripsi' => 'Upacara bendera rutin setiap hari Senin di lapangan sekolah. Seluruh siswa dan guru wajib hadir.',
            ],
            [
                'judul' => 'Rapat Orang Tua Murid',
                'tanggal' => '2026-06-20',
                'deskripsi' => 'Rapat orang tua murid kelas X, XI, dan XII dalam rangka sosialisasi program sekolah semester genap.',
            ],
            [
                'judul' => 'Ujian Akhir Semester Genap',
                'tanggal' => '2026-06-23',
                'deskripsi' => 'Pelaksanaan ujian akhir semester genap untuk seluruh siswa kelas X, XI, dan XII.',
            ],
            [
                'judul' => 'Class Meeting',
                'tanggal' => '2026-07-01',
                'deskripsi' => 'Kegiatan class meeting setelah ujian akhir semester. Berbagai lomba antar kelas.',
            ],
            [
                'judul' => 'Pembagian Rapor Semester Genap',
                'tanggal' => '2026-07-10',
                'deskripsi' => 'Pembagian rapor semester genap tahun ajaran 2025/2026. Orang tua diharapkan hadir.',
            ],
            [
                'judul' => 'Libur Semester Genap',
                'tanggal' => '2026-07-13',
                'deskripsi' => 'Libur semester genap tahun ajaran 2025/2026 untuk seluruh siswa.',
            ],
            [
                'judul' => 'Masa Pengenalan Lingkungan Sekolah (MPLS)',
                'tanggal' => '2026-07-20',
                'deskripsi' => 'MPLS untuk siswa baru kelas X tahun ajaran 2026/2027. Kegiatan pengenalan lingkungan dan program sekolah.',
            ],
            [
                'judul' => 'Hari Pertama Masuk Sekolah',
                'tanggal' => '2026-07-27',
                'deskripsi' => 'Hari pertama masuk sekolah tahun ajaran 2026/2027 untuk seluruh siswa.',
            ],
            [
                'judul' => 'Peringatan Hari Kemerdekaan RI ke-81',
                'tanggal' => '2026-08-17',
                'deskripsi' => 'Upacara peringatan HUT RI ke-81 dan berbagai lomba 17-an.',
            ],
            [
                'judul' => 'Pentas Seni Akhir Tahun',
                'tanggal' => '2026-12-14',
                'deskripsi' => 'Pentas seni tahunan yang menampilkan bakat dan kreativitas siswa di bidang seni dan budaya.',
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }

        $this->command->info('Agenda berhasil dibuat.');
    }

    protected function seedAlumni(): void
    {
        $alumnis = [
            ['nama' => 'Anindya Putri', 'tahun_lulus' => '2020', 'pekerjaan' => 'Mahasiswa Kedokteran UI'],
            ['nama' => 'Bima Sakti Pratama', 'tahun_lulus' => '2020', 'pekerjaan' => 'Mahasiswa Teknik Informatika ITB'],
            ['nama' => 'Citra Ayu Kusuma', 'tahun_lulus' => '2020', 'pekerjaan' => 'Mahasiswa Hukum UGM'],
            ['nama' => 'Dimas Aditya Nugroho', 'tahun_lulus' => '2021', 'pekerjaan' => 'Mahasiswa Teknik Sipil UI'],
            ['nama' => 'Ella Permata Sari', 'tahun_lulus' => '2021', 'pekerjaan' => 'Mahasiswa Farmasi UNPAD'],
            ['nama' => 'Fajar Hidayat', 'tahun_lulus' => '2021', 'pekerjaan' => 'Software Engineer di Gojek'],
            ['nama' => 'Gita Puspita Dewi', 'tahun_lulus' => '2022', 'pekerjaan' => 'Mahasiswa Psikologi UGM'],
            ['nama' => 'Hendra Lesmana', 'tahun_lulus' => '2022', 'pekerjaan' => 'Mahasiswa Manajemen UI'],
            ['nama' => 'Intan Permata Hati', 'tahun_lulus' => '2022', 'pekerjaan' => 'Mahasiswa Ilmu Komunikasi UNJ'],
            ['nama' => 'Joko Wicaksono', 'tahun_lulus' => '2022', 'pekerjaan' => 'Junior Data Analyst di Tokopedia'],
            ['nama' => 'Kartika Sari', 'tahun_lulus' => '2023', 'pekerjaan' => 'Mahasiswa Akuntansi UI'],
            ['nama' => 'Lukman Prasetyo', 'tahun_lulus' => '2023', 'pekerjaan' => 'Mahasiswa Teknik Mesin UGM'],
            ['nama' => 'Mega Wati', 'tahun_lulus' => '2023', 'pekerjaan' => 'Mahasiswa Desain Komunikasi Visual ITB'],
            ['nama' => 'Nanda Pratama', 'tahun_lulus' => '2023', 'pekerjaan' => 'Mahasiswa Ilmu Politik UI'],
            ['nama' => 'Olivia Christy', 'tahun_lulus' => '2024', 'pekerjaan' => 'Mahasiswa Hubungan Internasional UPN'],
            ['nama' => 'Panji Kusumo', 'tahun_lulus' => '2024', 'pekerjaan' => 'Mahasiswa Teknik Elektro ITS'],
            ['nama' => 'Rizky Pratama', 'tahun_lulus' => '2024', 'pekerjaan' => 'Mahasiswa Sistem Informasi UI'],
            ['nama' => 'Salsabila Putri', 'tahun_lulus' => '2024', 'pekerjaan' => 'Mahasiswa Ilmu Gizi IPB'],
            ['nama' => 'Taufik Hidayat', 'tahun_lulus' => '2020', 'pekerjaan' => 'Guru SD Negeri Jakarta'],
            ['nama' => 'Uswatun Hasanah', 'tahun_lulus' => '2021', 'pekerjaan' => 'Perawat di RS Cipto Mangunkusumo'],
        ];

        foreach ($alumnis as $alumni) {
            Alumni::create($alumni);
        }

        $this->command->info('Alumni berhasil dibuat.');
    }

    protected function seedBanner(): void
    {
        $banners = [
            [
                'title' => 'Selamat Datang di SMA Negeri 1 Jakarta',
                'subtitle' => 'Mewujudkan generasi berkarakter, disiplin, unggul, dan berwawasan global.',
                'image' => 'banners/banner1.jpg',
                'link' => '/profil',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Prestasi Gemilang',
                'subtitle' => 'Berbagai prestasi telah diraih oleh siswa-siswi kami di tingkat kota, provinsi, hingga nasional.',
                'image' => 'banners/banner2.jpg',
                'link' => '/prestasi',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Fasilitas Lengkap & Modern',
                'subtitle' => 'Didukung dengan fasilitas belajar yang lengkap dan modern untuk menunjang proses pembelajaran.',
                'image' => 'banners/banner3.jpg',
                'link' => '/fasilitas',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        $this->command->info('Banner berhasil dibuat.');
    }

    protected function seedOrangTuaSiswa(): void
    {
        $orangTuaEmails = [
            'budi.ortu@sekolah.test',
            'siti.ortu@sekolah.test',
            'ahmad.ortu@sekolah.test',
            'dewi.ortu@sekolah.test',
            'hendra.ortu@sekolah.test',
        ];

        $siswas = Siswa::all();

        foreach ($orangTuaEmails as $index => $email) {
            $orangTua = OrangTua::where('email', $email)->first();
            if ($orangTua) {
                $start = $index * 14;
                $children = $siswas->slice($start, 14);
                foreach ($children as $siswa) {
                    $orangTua->anakSiswa()->syncWithoutDetaching([$siswa->id]);
                }
            }
        }

        $this->command->info('Orang tua - siswa berhasil ditautkan.');
    }

    protected function seedAbsensi(): void
    {
        $siswas = Siswa::all();
        $statuses = ['hadir', 'sakit', 'izin', 'alpha'];
        $weights = [60, 10, 10, 10, 10];

        $today = Carbon::today();
        $startDate = Carbon::today()->subWeekdays(20);

        $total = 0;
        for ($date = $startDate; $date->lte($today); $date->addDay()) {
            if ($date->isWeekend()) continue;

            foreach ($siswas as $siswa) {
                $status = $this->weightedRandom($statuses, $weights);

                $checkIn = $status === 'hadir'
                    ? Carbon::parse($date->format('Y-m-d') . ' 07:' . rand(0, 15) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT))
                    : ($status === 'terlambat'
                        ? Carbon::parse($date->format('Y-m-d') . ' 07:' . rand(16, 30) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT))
                        : null);

                $checkOut = $checkIn
                    ? Carbon::parse($checkIn->format('Y-m-d') . ' 1' . rand(4, 6) . ':' . str_pad(rand(0, 59), 2, '0', STR_PAD_LEFT))
                    : null;

                Absensi::create([
                    'siswa_id' => $siswa->id,
                    'rfid' => $siswa->rfid ?? '-',
                    'tanggal' => $date->format('Y-m-d'),
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                ]);

                $total++;
            }
        }

        $this->command->info("Absensi berhasil dibuat ({$total} records).");
    }

    protected function weightedRandom(array $items, array $weights): string
    {
        $total = array_sum($weights);
        $rand = mt_rand(1, $total);
        foreach ($items as $i => $item) {
            $rand -= $weights[$i];
            if ($rand <= 0) return $item;
        }
        return $items[0];
    }
}
