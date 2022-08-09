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
        Schema::create('kondisis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->nullable();
            $table->foreignId('pemakaian_id')->nullable();
            $table->integer('monitor');
            $table->integer('cpu');
            $table->integer('keyboard');
            $table->integer('mouse');
            $table->integer('proyektor');
            $table->integer('ac');
            $table->integer('lainnya');
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
        Schema::dropIfExists('kondisis');
    }
};
