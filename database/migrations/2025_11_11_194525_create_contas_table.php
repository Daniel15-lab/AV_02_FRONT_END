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
    
    Schema::create('contas', function (Blueprint $table) {
            $table->id();
            $table->string('descricao');
            $table->decimal('preco', 10, 2);
            $table->timestamp('data_vencimento')->nullable();
            $table->timestamp('data_pagamento')->nullable();
            $table->enum('status', ['Aberta', 'Quitada'])->default('Aberta');
            $table->timestamps(); // cria created_at e updated_at
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contas');
    }
};
