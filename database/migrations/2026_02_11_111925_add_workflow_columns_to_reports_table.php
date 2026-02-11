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
        Schema::table('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('disposition_to_region_id')->nullable()->after('report_status');
            $table->text('disposition_notes')->nullable()->after('disposition_to_region_id');
            $table->text('investigation_notes')->nullable()->after('disposition_notes');
            $table->text('resolution_notes')->nullable()->after('investigation_notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'disposition_to_region_id',
                'disposition_notes',
                'investigation_notes',
                'resolution_notes'
            ]);
        });
    }
};
