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
        Schema::create('data_mentahs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->boolean('isPrediksi')->default(0);
            $table->string('nama');
            $table->enum('kategori', ['hardware cpu', 'komponen cpu', 'komponen elektronik', 'komponen internet', 'komponen kabel', 'komponen material']);
            $table->enum('satuan', ['non pcs', 'pcs']);
            $table->string('tahun_pengadaan');
            $table->integer('jumlah_pengadaan');
            $table->integer('isi_barang_persatuan');
            $table->integer('jumlah_barang_perpcs');
            $table->integer('jumlah_matkul');
            $table->integer('jumlah_siswa_perkelas');
            $table->integer('jumlah_kelas');
            $table->enum('jenis_pemegang_barang', ['orang', 'kelas']);
            $table->integer('jumlah_pemegang_barang');
            $table->integer('jumlah_kebutuhan_total');
            $table->integer('harga_barang_beli');
            $table->integer('stok_barang');
            $table->enum('jenis_bahan', ['habis', 'tidak habis']);
            $table->enum('label', ['layak', 'tidak layak'])->nullable();
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
        Schema::dropIfExists('data_mentahs');
    }
};
