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
        Schema::create('pemakaians', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->foreignUuid('kegiatan_id')->references('id')->on('kegiatans');
            $table->foreignUuid('barangpakai_id')->references('id')->on('barang_pakais');
            $table->string('nama');
            $table->text('deskripsi');
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
        Schema::dropIfExists('pemakaians');
    }
};
