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
        Schema::create('people', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('couple_id');
            $table->enum('role', ['groom', 'bride']);
            $table->string('full_name', 100);
            $table->string('image_url', 255)->nullable();
            $table->text('additional_info')->nullable();
            $table->timestamps();
            
            $table->foreign('couple_id')->references('id')->on('couples')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('people');
    }
};