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
use App\Models\BarangHabis;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
use App\Models\Penggunaan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'id' => (string) Uuid::uuid4(),
            'nomor_induk' => '1010',
            'nama' => 'admin',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
        ]);

        $dosenslamet = (string) Uuid::uuid4();
        User::create([
            'id' => $dosenslamet,
            'nomor_induk' => '2020',
            'nama' => 'slamet',
            'role' => 'dosen',
            'email' => 'slamet@gmail.com',
            'password' => bcrypt('slamet'),
        ]);

        $dosencepi = (string) Uuid::uuid4();
        User::create([
            'id' => $dosencepi,
            'nomor_induk' => '5050',
            'nama' => 'cepi',
            'role' => 'dosen',
            'email' => 'cepi@gmail.com',
            'password' => bcrypt('cepi'),
        ]);

        $mahasiswa = (string) Uuid::uuid4();
        User::create([
            'id' => $mahasiswa,
            'nomor_induk' => '3030',
            'nama' => 'tia',
            'role' => 'mahasiswa',
            'email' => 'tia@gmail.com',
            'password' => bcrypt('tia'),
        ]);

        $staff = (string) Uuid::uuid4();
        User::create([
            'id' => $staff,
            'nomor_induk' => '4040',
            'nama' => 'syifa',
            'role' => 'staff',
            'email' => 'syifa@gmail.com',
            'password' => bcrypt('syifa'),
        ]);

        $dospemslamet = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dospemslamet,
            'user_id' => $dosenslamet,
            'jabatan' => 'Dosen Pengampu',
            'jurusan' => 'Manajemen Informatika',
            'kepalalab' => 'true'
        ]);

        $dospemcepi = (string) Uuid::uuid4();
        Dosen::create([
            'id' => $dospemcepi,
            'user_id' => $dosencepi,
            'jabatan' => 'Dosen Pengampu',
            'jurusan' => 'E-Commerce',
            'kepalalab' => 'false'
        ]);

        Mahasiswa::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $mahasiswa,
            'angkatan' => 2020,
        ]);

        Staff::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $staff,
            'bidang' => 'administrasi',
        ]);

        $laboratorium = (string) Uuid::uuid4();
        Laboratorium::create([
            'id' => $laboratorium,
            'user_id' => $dosenslamet,
            'nama' => 'LAB Jaringan',
            'deskripsi' => 'Lab untuk praktik jaringan',
        ]);

        $alat = (string) Uuid::uuid4();
        Alat::create([
            'id' => $alat,
            'nama' => 'Dell PC High Ultra',
            'merk' => 'Dell',
            'spesifikasi' => 'i7 gen7',
            'harga' => 8000000,
            'stok' => 30,
        ]);

        $bahan = (string) Uuid::uuid4();
        Bahan::create([
            'id' => $bahan,
            'nama' => 'Konektor RJ45',
            'merk' => 'RJ',
            'spesifikasi' => 'kuat dan tahan lama',
            'harga' => 200000,
            'stok' => 20,
        ]);

        $kodebarangpakai = (string) Uuid::uuid4();
        BarangPakai::create([
            'id' => $kodebarangpakai,
            'alat_id' => $alat,
            'laboratorium_id' => $laboratorium,
            'nama' => 'PC No 1',
            'kode' => bin2hex(random_bytes(4)),
            'deskripsi' => 'komputer Dell',
            'keterangan' => 'Baik',
        ]);

        $kodebaranghabis = (string) Uuid::uuid4();
        BarangHabis::create([
            'id' => $kodebaranghabis,
            'bahan_id' => $bahan,
            'laboratorium_id' => $laboratorium,
            'nama' => 'RJ45 No 1 Jarkom',
            'kode' => bin2hex(random_bytes(4)),
            'deskripsi' => 'Penghubung internet',
            'keterangan' => 'Baik',
        ]);

        $peminjamansetuju = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $peminjamansetuju,
            'user_id' => $mahasiswa,
            'dospem_id' => $dospemcepi,
            'laboratorium_id' => $laboratorium,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'Difest',
            'deskripsi' => 'Digital Festival',
            'jenis' => 'peminjaman',
            'status' => 'disetujui',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => '2023-03-26 14:39:00',
        ]);

        $peminjamanmenunggu = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $peminjamanmenunggu,
            'user_id' => $mahasiswa,
            'dospem_id' => $dospemcepi,
            'laboratorium_id' => $laboratorium,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'Revisi Tugas',
            'deskripsi' => 'Tugas Proyek Akhir',
            'jenis' => 'peminjaman',
            'status' => 'menunggu',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => null,
        ]);

        $perkuliahan = (string) Uuid::uuid4();
        Kegiatan::create([
            'id' => $perkuliahan,
            'user_id' => $dosenslamet,
            'dospem_id' => $dospemslamet,
            'laboratorium_id' => $laboratorium,
            'kode' => bin2hex(random_bytes(4)),
            'nama' => 'PAM pertemuan 6',
            'deskripsi' => 'User Interface',
            'jenis' => 'perkuliahan',
            'status' => 'disetujui',
            'mulai' => '2023-03-25 14:39:00',
            'selesai' => '2023-03-26 14:39:00',
        ]);

        Pemakaian::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $mahasiswa,
            'kegiatan_id' => $perkuliahan,
            'barangpakai_id' => $kodebarangpakai,
            'keterangan' => 'PC Lambat',
            'status' => 'selesai',
            'mulai' => '2023-03-26 14:39:00',
            'selesai' => '2023-03-27 14:39:00',
        ]);

        Penggunaan::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $mahasiswa,
            'kegiatan_id' => $perkuliahan,
            'baranghabis_id' => $kodebaranghabis,
            'jumlah' => 2,
            'status' => 'disetujui',
            'keterangan' => 'Kondisi Bekas',
            'tanggal' => '2023-03-26 14:39:00',
        ]);
    }
}
