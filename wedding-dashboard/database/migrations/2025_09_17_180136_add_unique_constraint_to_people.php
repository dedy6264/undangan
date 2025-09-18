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
        // First, we need to clean up duplicate records
        $duplicates = DB::table('people')
            ->select('couple_id', 'role', DB::raw('COUNT(*) as count'))
            ->groupBy('couple_id', 'role')
            ->havingRaw('COUNT(*) > 1')
            ->get();
        
        foreach ($duplicates as $duplicate) {
            // Keep the first record and delete the rest
            $ids = DB::table('people')
                ->where('couple_id', $duplicate->couple_id)
                ->where('role', $duplicate->role)
                ->pluck('id')
                ->toArray();
            
            // Remove the first ID (keep it)
            array_shift($ids);
            
            // Delete the rest
            if (!empty($ids)) {
                DB::table('people')->whereIn('id', $ids)->delete();
            }
        }
        
        // Add unique constraint on couple_id and role
        Schema::table('people', function (Blueprint $table) {
            $table->unique(['couple_id', 'role']);
        });
        
        // Update all existing records to use the new person_index format
        Person::all()->each(function ($person) {
            $person->person_index = $person->generatePersonIndex();
            $person->save();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('people', function (Blueprint $table) {
            $table->dropUnique(['couple_id', 'role']);
        });
    }
};
