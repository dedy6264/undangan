<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Person;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->string('person_index')->nullable()->after('id');
        });
        
        // Populate existing records with person_index
        Person::all()->each(function ($person) {
            $person->person_index = $person->generatePersonIndex();
            $person->save();
        });
        
        // Make the column non-nullable
        Schema::table('people', function (Blueprint $table) {
            $table->string('person_index')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropColumn('person_index');
        });
    }
};
