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
        Schema::create('planets', function (Blueprint $table) {
            $table->id();
            $table->string('title', 45)->nullable();
            $table->string('desc', 45)->nullable();
            $table->string('image', 225)->nullable();
            $table->string('status', 45)->nullable();
            $table->string('duration', 45)->nullable();
            $table->string('hours', 45)->nullable();
            $table->foreignId('galaxy_id')->constrained('galaxies')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('module_id')->constrained('modules')->onDelete('restrict')->onUpdate('restrict');
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planets');
    }
};
