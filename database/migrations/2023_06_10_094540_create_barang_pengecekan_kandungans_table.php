<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangPengecekanKandungansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_pengecekan_kandungans', function (Blueprint $table) {
            $table->foreignId('barang_pengecekan_id')->constrained();
            $table->foreignId('kandungan_id')->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_pengecekan_kandungans');
    }
}
