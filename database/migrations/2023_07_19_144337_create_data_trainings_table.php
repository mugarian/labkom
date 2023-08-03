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
        Schema::create('data_trainings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('datamentah_id')->references('id')->on('data_mentahs');
            $table->boolean('isPrediksi')->default(0);
            $table->enum('jenis_pengadaan', ['sesuai kuota', 'melebihi kuota', 'kurang dari kuota']);
            $table->enum('jenis_harga', ['murah', 'sedang', 'mahal', 'sangat mahal'])->nullable();
            $table->enum('jenis_stok', ['stok lebih', 'stok pas', 'stok kurang']);
            $table->string('tahun_pengadaan');
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
        Schema::dropIfExists('data_trainings');
    }
};
