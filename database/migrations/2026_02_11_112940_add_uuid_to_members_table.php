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
        Schema::table('members', function (Blueprint $table) {
            $table->uuid('uuid')->after('id')->nullable()->unique();
        });
        
        // Fill existing members with UUID
        $members = \DB::table('members')->whereNull('uuid')->get();
        foreach ($members as $member) {
            \DB::table('members')->where('id', $member->id)->update(['uuid' => \Str::uuid()]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
};
