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
        Schema::create('barang_habis', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bahanpraktikum_id')->references('id')->on('bahan_praktikums');
            $table->foreignUuid('laboratorium_id')->references('id')->on('laboratorium');
            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('foto')->nullable();
            $table->text('deskripsi');
            $table->text('keterangan');
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
        Schema::dropIfExists('barang_habis');
    }
};
