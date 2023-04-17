<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Alat;
use App\Models\User;
use App\Models\Bahan;
use App\Models\Dosen;
use App\Models\Staff;
use Ramsey\Uuid\Uuid;
use App\Models\Kegiatan;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Penggunaan;
use App\Models\BarangHabis;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
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
            'jabatan' => 'ketua prodi',
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
         * MahasiswaSeeder
         */

        Mahasiswa::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'angkatan' => 2020,
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

        $alat = (string) Uuid::uuid4();
        Alat::create([
            'id' => $alat,
            'nama' => 'Dell PC High Ultra',
            'merk' => 'Dell',
            'spesifikasi' => 'i7 gen7',
            'harga' => 8000000,
            'stok' => 30,
        ]);

        /**
         * BahanSeeder
         */

        $bahan = (string) Uuid::uuid4();
        Bahan::create([
            'id' => $bahan,
            'nama' => 'Konektor RJ45',
            'merk' => 'RJ',
            'spesifikasi' => 'kuat dan tahan lama',
            'harga' => 200000,
            'stok' => 20,
        ]);

        /**
         * BarangPakaiSeeder
         */

        $bpUX = (string) Uuid::uuid4();
        BarangPakai::create([
            'id' => $bpUX,
            'alat_id' => $alat,
            'laboratorium_id' => $labUX,
            'nama' => 'PC No 1',
            'kode' => bin2hex(random_bytes(4)),
            'deskripsi' => 'komputer Dell',
            'keterangan' => 'Baik',
        ]);

        $bpJaringan = (string) Uuid::uuid4();
        BarangPakai::create([
            'id' => $bpJaringan,
            'alat_id' => $alat,
            'laboratorium_id' => $labJaringan,
            'nama' => 'PC No 5',
            'kode' => bin2hex(random_bytes(4)),
            'deskripsi' => 'PC Dell',
            'keterangan' => 'Biasa',
        ]);

        /**
         * BarangHabisSeeder
         */

        $bhJaringan = (string) Uuid::uuid4();
        BarangHabis::create([
            'id' => $bhJaringan,
            'bahan_id' => $bahan,
            'laboratorium_id' => $labJaringan,
            'nama' => 'RJ45 No 1 Jarkom',
            'kode' => bin2hex(random_bytes(4)),
            'deskripsi' => 'Penghubung internet',
            'keterangan' => 'Baik',
        ]);

        $bhUX = (string) Uuid::uuid4();
        BarangHabis::create([
            'id' => $bhUX,
            'bahan_id' => $bahan,
            'laboratorium_id' => $labUX,
            'nama' => 'Kertas A4 UX',
            'kode' => bin2hex(random_bytes(4)),
            'deskripsi' => 'Kertas Printeran',
            'keterangan' => 'Baik',
        ]);

        /**
         * PelaksanaanSeeder
         */

        $pelaksanaan = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $pelaksanaan,
            'user_id' => $userSlamet,
            'dospem_id' => $dosenSlamet,
            'laboratorium_id' => $labJaringan,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'PAM pertemuan 6',
            'deskripsi' => 'User Interface',
            'jenis' => 'pelaksanaan',
            'tipe' => 'perkuliahan',
            'status' => 'disetujui',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => '2023-03-26 14:39:00',
        ]);

        /**
         * PermohonanSeeder
         *  | PermohonanDisetujui
         *  | PermohonanDitolak
         *  | PermohonanDiverifikasi
         *  | PermohonanMenunggu
         */

        //  PermohonanDisetujui
        $permohonanSetuju = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $permohonanSetuju,
            'user_id' => $userTia,
            'dospem_id' => $dosenCepi,
            'laboratorium_id' => $labUX,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'Difest',
            'deskripsi' => 'Digital Festival',
            'jenis' => 'permohonan',
            'tipe' => 'non perkuliahan',
            'status' => 'disetujui',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => '2023-03-26 14:39:00',
        ]);

        // PermohonanDitolak
        $permohonanTolak = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $permohonanTolak,
            'user_id' => $userTia,
            'dospem_id' => $dosenSlamet,
            'laboratorium_id' => $labJaringan,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'Istirahat',
            'deskripsi' => 'Menunggu matkul',
            'jenis' => 'permohonan',
            'tipe' => 'non perkuliahan',
            'status' => 'ditolak',
            'keterangan' => 'lab sedang dipakai',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => null,
        ]);

        // PermohonanDiverifikasi
        $permohonanVerifikasi = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $permohonanVerifikasi,
            'user_id' => $userNur,
            'dospem_id' => $dosenNur,
            'laboratorium_id' => $labUX,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'APSI pertemuan 2',
            'deskripsi' => 'Presentasi tugas APSI',
            'jenis' => 'permohonan',
            'tipe' => 'perkuliahan',
            'status' => 'diverifikasi',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => null,
        ]);

        // PermohonanMenunggu
        $permohonanTunggu = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $permohonanTunggu,
            'user_id' => $userTia,
            'dospem_id' => $dosenNur,
            'laboratorium_id' => $labJaringan,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'Japok',
            'deskripsi' => 'Kerja Kelompok APSI',
            'jenis' => 'permohonan',
            'tipe' => 'non perkuliahan',
            'status' => 'menunggu',
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
            'kegiatan_id' => $pelaksanaan,
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
         * | PenggunaanMenungguJaringan
         * | PenggunaanMenungguUX
         */

        //  PenggunaanDisetujui
        Penggunaan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $pelaksanaan,
            'baranghabis_id' => $bhJaringan,
            'jumlah' => 2,
            'status' => 'disetujui',
            'tanggal' => '2023-03-26 14:39:00',
        ]);

        // PenggunaanDitolak
        Penggunaan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $pelaksanaan,
            'baranghabis_id' => $bhJaringan,
            'jumlah' => 2,
            'status' => 'ditolak',
            'keterangan' => 'Kondisi Rusak',
            'tanggal' => '2023-03-26 14:39:00',
        ]);

        // PenggunaanMenungguJaringan
        Penggunaan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $pelaksanaan,
            'baranghabis_id' => $bhJaringan,
            'jumlah' => 2,
            'status' => 'menunggu',
            'tanggal' => '2023-03-26 14:39:00',
        ]);
        // PenggunaanMenungguUX
        Penggunaan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $userTia,
            'kegiatan_id' => $permohonanSetuju,
            'baranghabis_id' => $bhUX,
            'jumlah' => 2,
            'status' => 'menunggu',
            'tanggal' => '2023-03-26 14:39:00',
        ]);
    }
}
