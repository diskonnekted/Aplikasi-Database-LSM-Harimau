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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('reporter_name');
            $table->string('whatsapp');
            $table->text('address');
            $table->string('status'); // anggota/ masyarakat biasa/ asn atau lembaga
            $table->string('title');
            $table->text('content');
            $table->boolean('is_truth_statement')->default(false);
            $table->string('report_status')->default('pending'); // pending, investigating, resolved, rejected
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
