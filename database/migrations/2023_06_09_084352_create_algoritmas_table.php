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
        Schema::create('algoritmas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->references('id')->on('users');
            $table->string('nama');
            $table->enum('pengajuan', ['sesuai', 'melebihi', 'kurang']);
            $table->enum('harga', ['mahal', 'murah']);
            $table->enum('jenis_bahan', ['habis', 'tidak habis']);
            $table->enum('label', ['layak', 'tidak layak']);
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
        Schema::dropIfExists('algoritmas');
    }
};
