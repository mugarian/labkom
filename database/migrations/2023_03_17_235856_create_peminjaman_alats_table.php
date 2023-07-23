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
        Schema::create('peminjaman_alats', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('barangpakai_id')->references('id')->on('barang_pakais');
            $table->text('deskripsi');
            $table->text('cpu')->nullable();
            $table->text('monitor')->nullable();
            $table->text('keyboard')->nullable();
            $table->text('mouse')->nullable();
            $table->text('kondisi')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'selesai'])->default('menunggu');
            $table->enum('jenis', ['luar', 'dalam']);
            $table->string('bukti')->nullable();
            $table->timestamp('tgl_pinjam')->nullable();
            $table->timestamp('tgl_kembali')->nullable();
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
        Schema::dropIfExists('peminjaman_alats');
    }
};
