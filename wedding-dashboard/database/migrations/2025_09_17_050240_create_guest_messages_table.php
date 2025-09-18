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
        Schema::create('guest_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guest_id');
            $table->unsignedBigInteger('wedding_event_id');
            $table->string('guest_name', 100)->nullable();
            $table->text('message');
            $table->boolean('is_approved')->default(false);
            $table->timestamps();
            
            $table->foreign('guest_id')->references('id')->on('guests')->onDelete('cascade');
            $table->foreign('wedding_event_id')->references('id')->on('wedding_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_messages');
    }
};