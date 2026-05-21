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
        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->string('no_dokumen', 50)->unique();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->enum('kode_pt', ['EFM', 'SSK', 'PAKAR', 'FIKA', 'KOPERASI']);
            $table->foreignId('departemen_id')->constrained('departemen');
            $table->foreignId('user_id')->constrained('users');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen');
    }
};
