<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->id();
            $table->string('usuario_responsavel');
            $table->string('nome')->unique();
            $table->string('nome_fantasia')->unique();
            $table->string('website')->unique()->nullable();
            $table->string('cnpj')->unique();
            $table->string('cep')->unique();
            $table->string('endereco_comercial');
            $table->string('email')->unique();
            $table->string('telefone')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado')->nullable();
            $table->string('ano_fundacao')->nullable();
            $table->integer('empregados')->nullable();
            $table->text('descricao')->nullable();
            $table->string('status_empresa')->default(true);
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
        Schema::dropIfExists('empresa');
    }
}
