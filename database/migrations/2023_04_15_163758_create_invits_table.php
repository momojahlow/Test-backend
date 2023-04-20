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
        Schema::create('invits', function (Blueprint $table) {
            $table->id();  
            $table->foreignId('societe_id')->constrained();          
            $table->string('email')->unique();
            $table->string('token')->nullable();
            $table->json('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invits');
    }
};
