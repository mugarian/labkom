<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Alat;
use App\Models\User;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Staff;
use Ramsey\Uuid\Uuid;
use App\Models\Kegiatan;
use App\Models\Algoritma;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use App\Models\Penggunaan;
use App\Models\BarangHabis;
use App\Models\BarangPakai;
use Illuminate\Support\Str;
use App\Models\BahanJurusan;
use App\Models\Laboratorium;
use App\Models\BahanPraktikum;
use App\Models\PeminjamanAlat;
use App\Models\PeminjamanBahan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /**
         * DIRECTORIES
         *
         * UserSeeder
         * DosenSeeder
         * KelasSeeder
         * MahasiswaSeeder
         * StaffSeeder
         * LaboratoriumSeeder
         * AlatSeeder
         * BahanSeeder
         * BarangPakaiSeeder
         * BarangHabisSeeder
         * PelaksanaanSeeder
         * PermohonanSeeder
         * PemakaianSeeder
         * PenggunaanSeeder
         * PeminjamanAlatSeeder
         * PeminjamanBahanSeeder
         * AlgoritmaSeeder
         *
         */

        /**
         *  UserSeeder
         *  | admins
         *  | kalabs
         *      | kalabMDI
         *      | kalabUX
         *      | kalabSI
         *      | kalabRPL
         *      | kalabJARKOM
         *  | dospems
         *  | kapro
         *  | kajur
         *  | userTias
         *  | staffs
         */

        //  admins
        User::create([
            'id' => (string) Uuid::uuid4(),
            'nomor_induk' => '1010',
            'nama' => 'admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        // kalabMDI
        $userHaryati = (string) Uuid::uuid4();
        User::create([
            'id' => $userHaryati,
            'nomor_induk' => '199306142019032021',
            'nama' => 'Haryati, S.Pd., M.Pd',
            'role' => 'dosen',
            'email' => 'haryati@gmail.com',
            'password' => Hash::make('haryati'),
        ]);

        // kalabUX
        $userCepi = (string) Uuid::uuid4();
        User::create([
            'id' => $userCepi,
            'nomor_induk' => '199109242022031001',
            'nama' => 'Chepy Perdana, S.Kom., M.Pd',
            'role' => 'dosen',
            'email' => 'chepy@gmail.com',
            'password' => Hash::make('chepy'),
        ]);

        // kalabSI
        $userTaufan = (string) Uuid::uuid4();
        User::create([
            'id' => $userTaufan,
            'nomor_induk' => '199311112022031006',
            'nama' => 'Taufan Abdurrachman, S.T., M.Kom.',
            'role' => 'dosen',
            'email' => 'taufan@gmail.com',
            'password' => Hash::make('taufan'),
        ]);

        // kalabRPL
        $userSari = (string) Uuid::uuid4();
        User::create([
            'id' => $userSari,
            'nomor_induk' => '199408182022032017',
            'nama' => 'Sari Azhariyah, S.Pd., M.Pd.T.',
            'role' => 'dosen',
            'email' => 'sari@gmail.com',
            'password' => Hash::make('sari'),
        ]);

        // kalabJARKOM
        $userSlamet = (string) Uuid::uuid4();
        User::create([
            'id' => $userSlamet,
            'nomor_induk' => '170900045',
            'nama' => 'Slamet Rahayu S.Pd., M.Pd.',
            'role' => 'dosen',
            'email' => 'slamet@gmail.com',
            'password' => Hash::make('slamet'),
        ]);

        // dospems
        $userNur = (string) Uuid::uuid4();
        User::create([
            'id' => $userNur,
            'nomor_induk' => '199603112020122022',
            'nama' => 'Nurfitria Khoirunnisa, S.Tr.Kom., M.Kom',
            'role' => 'dosen',
            'email' => 'nur@gmail.com',
            'password' => Hash::make('nur'),
        ]);

        // kapro
        $userDwi = (string) Uuid::uuid4();
        User::create([
            'id' => $userDwi,
            'nomor_induk' => '199104302019032018',
            'nama' => 'Dwi Vernanda S.T., M.Pd',
            'role' => 'dosen',
            'email' => 'dwi@gmail.com',
            'password' => Hash::make('dwi'),
        ]);

        //wakil rektor
        $userNunu = (string) Uuid::uuid4();
        User::create([
            'id' => $userNunu,
            'nomor_induk' => '197909152015041000',
            'nama' => 'Nunu Nugraha Purnawan, S.Pd., M.Kom',
            'role' => 'dosen',
            'email' => 'nunu@gmail.com',
            'password' => Hash::make('nunu'),
        ]);

        // kajur
        $userTri = (string) Uuid::uuid4();
        User::create([
            'id' => $userTri,
            'nomor_induk' => '198801052019031008',
            'nama' => 'Tri Herdiawan Apandi, S.ST., M.T.',
            'role' => 'dosen',
            'email' => 'tri@gmail.com',
            'password' => Hash::make('tri'),
        ]);

        // userTias
        $userTia = (string) Uuid::uuid4();
        User::create([
            'id' => $userTia,
            'nomor_induk' => '10107061',
            'nama' => 'Tia Rostiawati',
            'role' => 'mahasiswa',
            'email' => 'tia@gmail.com',
            'password' => Hash::make('tia'),
        ]);

        $userRahma = (string) Uuid::uuid4();
        User::create([
            'id' => $userRahma,
            'nomor_induk' => '10107048',
            'nama' => 'Rahma Kurnia',
            'role' => 'mahasiswa',
            'email' => 'rahma@gmail.com',
            'password' => Hash::make('rahma'),
        ]);

        // staffs
        $staff = (string) Uuid::uuid4();
        User::create([
            'id' => $staff,
            'nomor_induk' => '210300082',
            'nama' => 'Syifa Rizkita Ananda, A.md.Kom',
            'role' => 'staff',
            'email' => 'syifa@gmail.com',
            'password' => Hash::make('syifa'),
        ]);

        /**
         * DosenSeeder
         */

        $dosenHaryati = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenHaryati,
            'user_id' => $userHaryati,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'true'
        ]);

        $dosenCepi = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenCepi,
            'user_id' => $userCepi,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'true'
        ]);

        $dosenTaufan = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenTaufan,
            'user_id' => $userTaufan,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'true'
        ]);

        $dosenSari = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenSari,
            'user_id' => $userSari,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'true'
        ]);

        $dosenSlamet = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenSlamet,
            'user_id' => $userSlamet,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'true'
        ]);

        $dosenNur = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenNur,
            'user_id' => $userNur,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'false'
        ]);

        $dosenDwi = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenDwi,
            'user_id' => $userDwi,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'false'
        ]);

        $dosenNunu = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenNunu,
            'user_id' => $userNunu,
            'jabatan' => 'dosen pengampu',
            'jurusan' => 'mi',
            'kepalalab' => 'false'
        ]);

        $dosenTri = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dosenTri,
            'user_id' => $userTri,
            'jabatan' => 'ketua jurusan',
            'jurusan' => 'mi',
            'kepalalab' => 'false'
        ]);

        /**
         * KelasSeeder
         */

        $si20a = (string) Uuid::uuid4();
        Kelas::create([
            'id' => $si20a,
            'dosen_id' => $dosenDwi,
            'nama' => 'SI A 2020',
            'angkatan' => '2020',
            'jurusan' => 'mi',
        ]);

        $si20b = (string) Uuid::uuid4();
        Kelas::create([
            'id' => $si20b,
            'dosen_id' => $dosenNunu,
            'nama' => 'SI B 2020',
            'angkatan' => '2020',
            'jurusan' => 'mi',
        ]);

        /**
         * MahasiswaSeeder
         */

        Mahasiswa::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kelas_id' => $si20a,
            'angkatan' => 2020,
            'jurusan' => 'mi',
        ]);

        Mahasiswa::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userRahma,
            'kelas_id' => $si20b,
            'angkatan' => 2020,
            'jurusan' => 'mi',
        ]);

        /**
         * StaffSeeder
         */

        Staff::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $staff,
            'bidang' => 'administrasi',
        ]);

        /**
         * LaboratoriumSeeder
         */

        $labMDI = (string) Uuid::uuid4();
        Laboratorium::create([
            'id' => $labMDI,
            'user_id' => $userHaryati,
            'nama' => 'LAB 1 MDI',
            'deskripsi' => 'Laboratorium Manajemen Data & Informasi',
        ]);

        $labUX = (string) Uuid::uuid4();
        Laboratorium::create([
            'id' => $labUX,
            'user_id' => $userCepi,
            'nama' => 'LAB 2 UX',
            'deskripsi' => 'Laboratorium User Experience',
        ]);

        $labSI = (string) Uuid::uuid4();
        Laboratorium::create([
            'id' => $labSI,
            'user_id' => $userTaufan,
            'nama' => 'LAB 3 SI',
            'deskripsi' => 'Laboratorium Sistem Informasi',
        ]);

        $labRPL = (string) Uuid::uuid4();
        Laboratorium::create([
            'id' => $labRPL,
            'user_id' => $userSari,
            'nama' => 'LAB 4 RPL',
            'deskripsi' => 'Laboratorium Rekayasa Perangkat Lunak',
        ]);

        $labJaringan = (string) Uuid::uuid4();
        Laboratorium::create([
            'id' => $labJaringan,
            'user_id' => $userSlamet,
            'nama' => 'LAB 5 Jarkom',
            'deskripsi' => 'Laboratorium Jaringan Komputer',
        ]);

        /**
         * AlatSeeder
         */

        $pcMDI = (string) Uuid::uuid4();
        Alat::create([
            'id' => $pcMDI,
            'nama' => 'PC Dell',
            'merk' => 'Dell PC High Ultra',
            'kategori' => 'pc',
            'spesifikasi' => 'i7 gen7',
        ]);

        $pcUX = (string) Uuid::uuid4();
        Alat::create([
            'id' => $pcUX,
            'nama' => 'PC HP',
            'merk' => 'HP PC Medium Spec',
            'kategori' => 'pc',
            'spesifikasi' => 'i5 gen3',
        ]);

        $pcSI = (string) Uuid::uuid4();
        Alat::create([
            'id' => $pcSI,
            'nama' => 'PC Asus',
            'merk' => 'Asus PC Low Spec',
            'kategori' => 'pc',
            'spesifikasi' => 'i3 gen3',
        ]);

        $pcRPL = (string) Uuid::uuid4();
        Alat::create([
            'id' => $pcRPL,
            'nama' => 'PC ROG',
            'merk' => 'ROG PC High End',
            'kategori' => 'pc',
            'spesifikasi' => 'i9 gen7',
        ]);

        $pcJaringan = (string) Uuid::uuid4();
        Alat::create([
            'id' => $pcJaringan,
            'nama' => 'PC Apple',
            'merk' => 'Apple PC Medium Middle',
            'kategori' => 'pc',
            'spesifikasi' => 'i5 gen5',
        ]);

        $nonpcJaringan = (string) Uuid::uuid4();
        Alat::create([
            'id' => $nonpcJaringan,
            'nama' => 'Epson Printer Jet',
            'merk' => 'BenQ',
            'kategori' => 'non-pc',
            'spesifikasi' => 'Ultra HD Ink',
        ]);

        /**
         * BahanSeeder
         */

        $baprakJaringan = (string) Uuid::uuid4();
        BahanPraktikum::create([
            'id' => $baprakJaringan,
            'laboratorium_id' => $labJaringan,
            'kode' => Str::random(8),
            'nama' => 'Prosessor Intel i9',
            'merk' => 'Intel',
            'jenis' => 'tidak habis',
            'spesifikasi' => '24 Core 6.0 Ghz',
            'harga' => 8000000,
            'stok' => 16,
        ]);

        $baprakUX = (string) Uuid::uuid4();
        BahanPraktikum::create([
            'id' => $baprakUX,
            'laboratorium_id' => $labUX,
            'kode' => Str::random(8),
            'nama' => 'A4 80mg UX',
            'merk' => 'SIDU',
            'jenis' => 'habis',
            'spesifikasi' => 'tebal dan halus',
            'harga' => 45000,
            'stok' => 500,
        ]);

        $bajurJaringan = (string) Uuid::uuid4();
        BahanJurusan::create([
            'id' => $bajurJaringan,
            'laboratorium_id' => $labJaringan,
            'bahanpraktikum_id' => $baprakJaringan,
            'kode' => Str::random(8),
            'stok' => 3,
        ]);



        /**
         * BarangPakaiSeeder
         */

        $bpUX = (string) Uuid::uuid4();
        BarangPakai::create([
            'id' => $bpUX,
            'alat_id' => $pcUX,
            'laboratorium_id' => $labUX,
            'nama' => 'PC No 1',
            'kode' => Str::random(8),
            'harga' => 4000000,
        ]);

        $bpJaringan = (string) Uuid::uuid4();
        BarangPakai::create([
            'id' => $bpJaringan,
            'alat_id' => $pcJaringan,
            'laboratorium_id' => $labJaringan,
            'nama' => 'PC No 5',
            'kode' => Str::random(8),
            'harga' => 8000000,
        ]);

        $bpRPL = (string) Uuid::uuid4();
        BarangPakai::create([
            'id' => $bpRPL,
            'alat_id' => $pcRPL,
            'laboratorium_id' => $labRPL,
            'nama' => 'PC No 2',
            'kode' => Str::random(8),
            'harga' => 12000000,
        ]);

        $bpPrinter = (string) Uuid::uuid4();
        BarangPakai::create([
            'id' => $bpPrinter,
            'alat_id' => $nonpcJaringan,
            'laboratorium_id' => $labJaringan,
            'nama' => 'Printer 99',
            'kode' => Str::random(8),
            'harga' => 3000000,
        ]);

        /**
         * BarangHabisSeeder
         */

        $bhJaringan = (string) Uuid::uuid4();
        BarangHabis::create([
            'id' => $bhJaringan,
            'bahanpraktikum_id' => $baprakJaringan,
            'laboratorium_id' => $labJaringan,
            'nama' => 'RJ45 No 1 Jarkom',
            'kode' => Str::random(8),
            'deskripsi' => 'Penghubung internet',
            'keterangan' => 'Baik',
        ]);

        $bhUX = (string) Uuid::uuid4();
        BarangHabis::create([
            'id' => $bhUX,
            'bahanpraktikum_id' => $baprakUX,
            'laboratorium_id' => $labUX,
            'nama' => 'Kertas A4 UX',
            'kode' => Str::random(8),
            'deskripsi' => 'Kertas Printeran',
            'keterangan' => 'Baik',
        ]);

        /**
         * PelaksanaanSeeder
         */

        $pelaksanaanJaringan = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $pelaksanaanJaringan,
            'user_id' => $userSlamet,
            'dospem_id' => $dosenSlamet,
            'laboratorium_id' => $labJaringan,
            'kelas_id' => $si20a,
            'kode' => Str::random(8),
            'nama' => 'PAM pertemuan 6',
            'deskripsi' => 'User Interface',
            'jenis' => 'pelaksanaan',
            'tipe' => 'perkuliahan',
            'verif_dospem' => 'disetujui',
            'verif_kalab' => 'disetujui',
            'status' => 'selesai',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => '2023-03-26 14:39:00',
        ]);

        $pelaksanaanUX = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $pelaksanaanUX,
            'user_id' => $userCepi,
            'dospem_id' => $dosenCepi,
            'laboratorium_id' => $labUX,
            'kelas_id' => $si20b,
            'kode' => Str::random(8),
            'nama' => 'Praktisi E-Commerce',
            'deskripsi' => 'Pengenalan Blibli',
            'jenis' => 'pelaksanaan',
            'tipe' => 'perkuliahan',
            'verif_dospem' => 'disetujui',
            'verif_kalab' => 'disetujui',
            'status' => 'berlangsung',
            'mulai' => '2023-06-01 08:10:00',
        ]);

        /**
         * PermohonanSeeder
         *  | PermohonanDisetujui
         *  | PermohonanDitolak
         */

        //  PermohonanDisetujui
        $permohonanSetuju = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $permohonanSetuju,
            'user_id' => $userTia,
            'dospem_id' => $dosenCepi,
            'laboratorium_id' => $labUX,
            'kelas_id' => $si20a,
            'kode' => Str::random(8),
            'nama' => 'Difest',
            'deskripsi' => 'Digital Festival',
            'jenis' => 'permohonan',
            'tipe' => 'non perkuliahan',
            'verif_dospem' => 'disetujui',
            'verif_kalab' => 'disetujui',
            'status' => 'selesai',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => '2023-03-26 14:39:00',
        ]);

        // PermohonanDitolak
        $permohonanTolak = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $permohonanTolak,
            'user_id' => $userRahma,
            'dospem_id' => $dosenSlamet,
            'laboratorium_id' => $labJaringan,
            'kelas_id' => $si20a,
            'kode' => Str::random(8),
            'nama' => 'Istirahat',
            'deskripsi' => 'Menunggu matkul',
            'jenis' => 'permohonan',
            'tipe' => 'non perkuliahan',
            'verif_dospem' => 'disetujui',
            'verif_kalab' => 'ditolak',
            'status' => 'ditolak',
            'keterangan' => 'lab sedang dipakai',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => null,
        ]);

        // PermohonanDiverifikasi

        // PermohonanMenunggu
        $permohonanTunggu = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $permohonanTunggu,
            'user_id' => $userTia,
            'dospem_id' => $dosenNur,
            'laboratorium_id' => $labJaringan,
            'kelas_id' => $si20a,
            'kode' => Str::random(8),
            'nama' => 'Japok',
            'deskripsi' => 'Kerja Kelompok APSI',
            'jenis' => 'permohonan',
            'tipe' => 'non perkuliahan',
            'verif_dospem' => 'ditolak',
            'verif_kalab' => 'menunggu',
            'status' => 'ditolak',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => null,
        ]);

        /**
         * PemakaianSeeder
         *  | pemakaianPerkuliahan
         *  | pemakaianNonPerkuliahan
         */

        //  PemakaianPerkuliahan
        Pemakaian::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $pelaksanaanJaringan,
            'barangpakai_id' => $bpJaringan,
            'keterangan' => 'PC Lambat',
            'status' => 'selesai',
            'mulai' => '2023-03-26 14:39:00',
            'selesai' => '2023-03-27 14:39:00',
        ]);

        //  PemakaianNonPerkuliahan
        Pemakaian::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $permohonanSetuju,
            'barangpakai_id' => $bpUX,
            'keterangan' => 'PC Biasa',
            'status' => 'selesai',
            'mulai' => '2023-03-26 14:39:00',
            'selesai' => '2023-03-27 14:39:00',
        ]);

        /**
         * PenggunaanSeeder
         * | PenggunaanDisetujui
         * | PenggunaanDitolak
         */

        //  PenggunaanDisetujui
        Penggunaan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $pelaksanaanJaringan,
            'bahanpraktikum_id' => $baprakJaringan,
            'jumlah' => 2,
            'status' => 'disetujui',
            'tanggal' => '2023-03-26 14:39:00',
        ]);

        // PenggunaanDitolak
        Penggunaan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $pelaksanaanUX,
            'bahanpraktikum_id' => $baprakJaringan,
            'jumlah' => 2,
            'status' => 'ditolak',
            'keterangan' => 'Kondisi Rusak',
            'tanggal' => '2023-03-26 14:39:00',
        ]);

        /**
         * PeminjamanAlatSeeder
         * | PeminjamanAlatDisetujui
         * | PeminjamanAlatDitolak
         */

        //  PeminjamanAlatDisetujui
        PeminjamanAlat::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'barangpakai_id' => $bpPrinter,
            'deskripsi' => 'Ngeprint Pamflet Difest',
            'kondisi' => 'Tinta Mampet',
            'keterangan' => null,
            'jenis' => 'dalam',
            'status' => 'selesai',
            'tgl_pinjam' => '2023-06-04 10:39:00',
            'tgl_kembali' => '2023-06-05 12:39:00',
        ]);

        //  PeminjamanAlatDitolak
        PeminjamanAlat::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'barangpakai_id' => $bpRPL,
            'deskripsi' => 'Kebutuhan jasa Pengetikan',
            'kondisi' => null,
            'keterangan' => 'Sedang dipakai praktikum',
            'jenis' => 'dalam',
            'status' => 'ditolak',
            'tgl_pinjam' => '2023-06-04 10:39:00',
            'tgl_kembali' => '2023-06-05 12:39:00',
        ]);

        /**
         * PeminjamanBahanSeeder
         * | PeminjamanBahanDisetujui
         * | PeminjamanBahanDitolak
         */

        //  PeminjamanBahanDisetujui
        PeminjamanBahan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'bahanjurusan_id' => $bajurJaringan,
            'deskripsi' => 'Pameran Difest',
            'kondisi' => 'Bagus',
            'keterangan' => null,
            'jenis' => 'dalam',
            'status' => 'selesai',
            'tgl_pinjam' => '2023-06-04 10:39:00',
            'tgl_kembali' => '2023-06-05 12:39:00',
        ]);

        //  PeminjamanBahanDitolak
        PeminjamanBahan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'bahanjurusan_id' => $bajurJaringan,
            'deskripsi' => 'Kebutuhan jualan difest',
            'kondisi' => null,
            'keterangan' => 'tidak diperjualbelikan',
            'jenis' => 'dalam',
            'status' => 'ditolak',
            'tgl_pinjam' => '2023-06-04 10:39:00',
            'tgl_kembali' => '2023-06-05 12:39:00',
        ]);

        // AlgoritmaSeeder
        // ke1
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Sunny',
            'temperature' => 'Hot',
            'humidity' => 'High',
            'windy' => 'False',
            'play' => 'No'
        ]);

        // ke2
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Sunny',
            'temperature' => 'Hot',
            'humidity' => 'High',
            'windy' => 'False',
            'play' => 'No'
        ]);

        // ke3
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Sunny',
            'temperature' => 'Hot',
            'humidity' => 'High',
            'windy' => 'True',
            'play' => 'No'
        ]);

        // ke4
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Cloudy',
            'temperature' => 'Hot',
            'humidity' => 'High',
            'windy' => 'False',
            'play' => 'Yes'
        ]);

        // ke5
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Rainy',
            'temperature' => 'Mild',
            'humidity' => 'High',
            'windy' => 'False',
            'play' => 'Yes'
        ]);

        // ke6
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Rainy',
            'temperature' => 'Cool',
            'humidity' => 'Normal',
            'windy' => 'False',
            'play' => 'Yes'
        ]);

        // ke7
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Rainy',
            'temperature' => 'Cool',
            'humidity' => 'Normal',
            'windy' => 'True',
            'play' => 'No'
        ]);

        // ke8
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Cloudy',
            'temperature' => 'Cool',
            'humidity' => 'Normal',
            'windy' => 'True',
            'play' => 'Yes'
        ]);

        // ke9
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Sunny',
            'temperature' => 'Mild',
            'humidity' => 'High',
            'windy' => 'False',
            'play' => 'No'
        ]);

        // ke10
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Sunny',
            'temperature' => 'Cool',
            'humidity' => 'Normal',
            'windy' => 'False',
            'play' => 'Yes'
        ]);

        // ke11
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Rainy',
            'temperature' => 'Mild',
            'humidity' => 'Normal',
            'windy' => 'False',
            'play' => 'Yes'
        ]);

        // ke12
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Sunny',
            'temperature' => 'Mild',
            'humidity' => 'Normal',
            'windy' => 'True',
            'play' => 'Yes'
        ]);

        // ke13
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Cloudy',
            'temperature' => 'Mild',
            'humidity' => 'High',
            'windy' => 'True',
            'play' => 'Yes'
        ]);

        // ke14
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Cloudy',
            'temperature' => 'Hot',
            'humidity' => 'Normal',
            'windy' => 'False',
            'play' => 'Yes'
        ]);

        // ke15
        Algoritma::create([
            'id' => (string) Uuid::uuid4(),
            'outlook' => 'Rainy',
            'temperature' => 'Mild',
            'humidity' => 'High',
            'windy' => 'True',
            'play' => 'No'
        ]);
    }
}
