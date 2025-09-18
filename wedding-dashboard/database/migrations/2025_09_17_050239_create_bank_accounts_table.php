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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wedding_event_id');
            $table->string('bank_name', 100);
            $table->string('account_number', 50);
            $table->string('account_holder_name', 100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('wedding_event_id')->references('id')->on('wedding_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};