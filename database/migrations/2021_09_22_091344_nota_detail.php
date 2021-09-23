<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NotaDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('qty')->default(0);
            $table->string('nama');
            $table->integer('harga')->default(0);
            $table->integer('total')->default(0);
            $table->integer('nota_id');
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
        Schema::dropIfExists('nota_detail');

    }
}
