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
            $table->foreignUuid('dospem_id')->references('id')->on('dosens');
            $table->foreignUuid('laboratorium_id')->references('id')->on('laboratorium');
            $table->string('kode')->unique();
            $table->string('nama');
            $table->string('deskripsi');
            $table->string('keterangan')->nullable();
            $table->enum('jenis', ['pelaksanaan', 'permohonan']);
            $table->enum('tipe', ['perkuliahan', 'non perkuliahan']);
            $table->enum('status', ['menunggu', 'diverifikasi', 'disetujui', 'selesai', 'ditolak'])->default('menunggu');
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
