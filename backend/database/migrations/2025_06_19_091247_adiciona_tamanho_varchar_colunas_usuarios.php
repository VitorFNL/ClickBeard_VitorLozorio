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
        Schema::table("usuarios", function (Blueprint $table) {
            $table->string('nome', 255)->change();
            $table->string('email', 255)->change();
            $table->string('senha', 255)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->string('nome')->change();
            $table->string('email')->change();
            $table->string('senha')->change();
        });
    }
};
