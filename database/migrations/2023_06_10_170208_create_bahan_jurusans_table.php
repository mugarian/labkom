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
        Schema::create('bahan_jurusans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laboratorium_id')->references('id')->on('laboratorium');
            $table->foreignUuid('bahanpraktikum_id')->references('id')->on('bahan_praktikums');
            $table->string('kode')->unique();
            $table->string('nama')->nullable();
            $table->string('merk')->nullable();
            $table->text('spesifikasi')->nullable();
            $table->integer('harga');
            $table->integer('stok');
            $table->string('tahun')->nullable();
            $table->string('foto')->nullable();
            $table->enum('status', ['tersedia', 'dipinjam', 'rusak'])->default('tersedia');
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
        Schema::dropIfExists('bahan_jurusans');
    }
};
