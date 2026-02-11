<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nik')->unique();
            $table->string('kta_number')->unique()->nullable();
            $table->string('full_name');
            $table->string('position')->nullable(); // Jabatan
            $table->string('birth_place');
            $table->date('birth_date');
            $table->text('address');
            $table->string('religion');
            $table->string('phone_number');
            $table->string('image_path')->nullable();
            $table->date('join_date')->nullable();
            $table->foreignId('region_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
