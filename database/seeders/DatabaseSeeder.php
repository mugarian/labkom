<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Alat;
use App\Models\User;
use App\Models\Bahan;
use App\Models\Dosen;
use App\Models\Staff;
use Ramsey\Uuid\Uuid;
use App\Models\Mahasiswa;
use App\Models\BarangHabis;
use App\Models\BarangPakai;
use App\Models\Laboratorium;
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

        $dosen = (string) Uuid::uuid4();
        User::create([
            'id' => $dosen,
            'nomor_induk' => '2020',
            'nama' => 'slamet',
            'role' => 'dosen',
            'email' => 'slamet@gmail.com',
            'password' => bcrypt('slamet'),
        ]);

        $dosen2 = (string) Uuid::uuid4();
        User::create([
            'id' => $dosen2,
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

        Dosen::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $dosen,
            'jabatan' => 'Dosen Pengampu',
            'jurusan' => 'Manajemen Informatika',
            'kepalalab' => 'true'
        ]);

        Dosen::create([
            'id' => (string) Uuid::uuid4(),
            'user_id' => $dosen2,
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
            'user_id' => $dosen,
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

        BarangPakai::create([
            'id' => (string) Uuid::uuid4(),
            'alat_id' => $alat,
            'laboratorium_id' => $laboratorium,
            'nama' => 'PC No 1',
            'kode' => 'AL12023PC',
            'deskripsi' => 'komputer Dell',
            'keterangan' => 'Baik',
        ]);

        BarangHabis::create([
            'id' => (string) Uuid::uuid4(),
            'bahan_id' => $bahan,
            'laboratorium_id' => $laboratorium,
            'nama' => 'RJ45 No 1 Jarkom',
            'kode' => 'BA12013RJ',
            'deskripsi' => 'Penghubung internet',
            'keterangan' => 'Baik',
        ]);
    }
}
