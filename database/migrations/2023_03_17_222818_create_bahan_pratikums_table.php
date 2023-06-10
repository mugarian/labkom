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
        Schema::create('bahan_praktikums', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('laboratorium_id')->references('id')->on('laboratorium');
            $table->string('kode')->unique();
            $table->enum('jenis', ['habis', 'tidak habis']);
            $table->string('nama');
            $table->string('merk');
            $table->text('spesifikasi');
            $table->integer('harga');
            $table->integer('stok');
            $table->string('foto')->nullable();
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
        Schema::dropIfExists('bahans');
    }
};
