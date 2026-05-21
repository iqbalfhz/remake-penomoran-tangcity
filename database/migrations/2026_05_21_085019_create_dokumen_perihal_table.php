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
        Schema::create('dokumen_perihal', function (Blueprint $table) {
            $table->foreignId('dokumen_id')->constrained('dokumen')->cascadeOnDelete();
            $table->foreignId('perihal_id')->constrained('perihal')->cascadeOnDelete();
            $table->primary(['dokumen_id', 'perihal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_perihal');
    }
};
