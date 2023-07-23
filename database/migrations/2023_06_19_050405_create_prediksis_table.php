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
        Schema::create('prediksis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->string('nama');
            $table->string('pengajuan');
            $table->string('harga');
            $table->string('label');
            $table->integer('jml_pengajuan');
            $table->integer('jml_matkul');
            $table->integer('jml_siswa');
            $table->integer('jml_kelas');
            $table->integer('harga_barang');
            $table->integer('harga_termurah');
            $table->integer('harga_termahal');
            $table->string('jenis_bahan');
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
        Schema::dropIfExists('prediksis');
    }
};
