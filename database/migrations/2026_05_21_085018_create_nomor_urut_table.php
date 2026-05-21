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
        Schema::create('nomor_urut', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->cascadeOnDelete();
            $table->enum('kode_pt', ['EFM', 'SSK', 'PAKAR', 'FIKA', 'KOPERASI']);
            $table->year('tahun');
            $table->unsignedInteger('no_urut')->default(0);
            $table->timestamps();
            $table->unique(['jenis_surat_id', 'kode_pt', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomor_urut');
    }
};
