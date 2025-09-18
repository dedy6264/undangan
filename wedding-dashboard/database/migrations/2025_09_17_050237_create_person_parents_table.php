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
        Schema::create('person_parents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('person_id');
            $table->string('father_name', 100)->nullable();
            $table->enum('father_status', ['alive', 'deceased'])->default('alive');
            $table->string('mother_name', 100)->nullable();
            $table->enum('mother_status', ['alive', 'deceased'])->default('alive');
            $table->timestamps();
            
            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('person_parents');
    }
};