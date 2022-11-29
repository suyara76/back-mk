<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaServicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa_servico', function (Blueprint $table) {
            $table->bigInteger('empresa_id')->unsigned();
            $table->bigInteger('servico_id')->unsigned();

            $table->foreign('empresa_id')->references('id')->on('empresa')->onDelete('cascade');
            $table->foreign('servico_id')->references('id')->on('tipo_servico')->onDelete('cascade');
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
        Schema::dropIfExists('empresa_servico');
    }
}
