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
        Schema::create('perihal', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 150);
            $table->foreignId('jenis_surat_id')->nullable()->constrained('jenis_surat')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perihal');
    }
};
