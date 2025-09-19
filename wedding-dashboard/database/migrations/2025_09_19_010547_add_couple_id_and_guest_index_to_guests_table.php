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
        Schema::table('guests', function (Blueprint $table) {
            $table->unsignedBigInteger('couple_id')->nullable()->after('id');
            $table->string('guest_index', 100)->unique()->nullable()->after('phone');
            
            // Add foreign key constraint
            $table->foreign('couple_id')->references('id')->on('couples')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign(['couple_id']);
            $table->dropColumn(['couple_id', 'guest_index']);
        });
    }
};
