<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFotoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('filename')->nullable();
            $table->longText('mime')->nullable();
            $table->longText('path')->nullable();
            $table->integer('size')->nullable();
            $table->boolean('status_foto')->default(true);
            $table->bigInteger('empresa_id')->unsigned()->nullable();
            
            $table->foreign('empresa_id')->references('id')->on('empresa')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('foto');
    }
}
