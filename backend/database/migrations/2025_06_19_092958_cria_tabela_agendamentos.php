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
        Schema::create("agendamentos", function (Blueprint $table) {
            $table->increments("agendamento_id");


            $table->unsignedInteger("usuario_id");
            $table->unsignedInteger("especialidade_id");
            $table->unsignedInteger("barbeiro_id");


            $table->date("data_agendamento");
            $table->time("hora_inicio");
            $table->time("hora_fim");
            $table->enum("status_agendamento", ["AGENDADO", "CANCELADO", "CONCLUIDO"])->default("AGENDADO");
            $table->timestamp("data_criacao")->useCurrent();
            $table->timestamp("data_atualizacao")->nullable()->useCurrent();


            $table->foreign("usuario_id")
                  ->references("usuario_id")
                  ->on("usuarios")
                  ->onDelete('cascade');

            $table->foreign("especialidade_id")
                  ->references("especialidade_id")
                  ->on("especialidades")
                  ->onDelete('cascade');

            $table->foreign("barbeiro_id")
                  ->references("barbeiro_id")
                  ->on("barbeiros")
                  ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
