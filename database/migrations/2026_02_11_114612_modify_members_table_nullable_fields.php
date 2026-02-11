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
            $table->foreignId('user_id')->nullable()->change();
            $table->string('nik')->nullable()->change();
            $table->string('birth_place')->nullable()->change();
            $table->date('birth_date')->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('religion')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Reverting is risky without data cleanup, but strict implementation would require it.
            // For now we keep it simple or just leave it nullable as it doesn't break anything.
            $table->foreignId('user_id')->nullable(false)->change();
            $table->string('nik')->nullable(false)->change();
            $table->string('birth_place')->nullable(false)->change();
            $table->date('birth_date')->nullable(false)->change();
            $table->text('address')->nullable(false)->change();
            $table->string('religion')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
        });
    }
};
