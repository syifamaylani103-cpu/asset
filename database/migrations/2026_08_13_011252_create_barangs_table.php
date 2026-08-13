<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('barangs', function (Blueprint $table) {
        $table->id();
        $table->string('kode_barang')->unique();
        $table->string('nama_barang');
        $table->foreignId('category_id')
              ->constrained('categories')
              ->onDelete('cascade');
        $table->integer('stok')->default(0);
        $table->decimal('harga', 15, 2)->default(0);
        $table->text('deskripsi')->nullable();
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
        Schema::dropIfExists('barangs');
    }
}
