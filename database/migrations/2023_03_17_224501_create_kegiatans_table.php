<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('dospem_id')->references('id')->on('dosens')->nullable();
            $table->foreignUuid('laboratorium_id')->references('id')->on('laboratorium');
            $table->foreignUuid('kelas_id')->references('id')->on('kelas')->nullable();
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('matakuliah')->nullable();
            $table->string('deskripsi');
            $table->string('keterangan')->nullable();
            $table->enum('jenis', ['pelaksanaan', 'permohonan']);
            $table->enum('tipe', ['perkuliahan', 'non perkuliahan']);
            $table->enum('verif_dospem', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->enum('verif_kalab', ['menunggu', 'disetujui', 'ditolak'])->default('menunggu');
            $table->enum('status', ['menunggu', 'terjadwal', 'disetujui', 'berlangsung', 'selesai', 'ditolak', 'digagalkan'])->default('menunggu');
            $table->enum('semester', ['ganjil', 'genap']);
            $table->year('tahun_ajaran');
            $table->timestamp('mulai')->nullable();
            $table->timestamp('selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kegiatans');
    }
};
