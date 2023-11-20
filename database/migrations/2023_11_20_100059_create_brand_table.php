<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('brand', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nama_brand', 100);
            $table->string('industri', 100);
            $table->string('didirikan', 100);
            $table->string('pendiri',100);
            $table->string('produk',100);
            $table->string('sejarah',74325);
            $table->string('gambar',100);
            $table->string('web',100);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand');
    }
};
