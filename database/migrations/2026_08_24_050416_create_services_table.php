<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('icon', 50)->default('fa-soap');
            $table->string('warna', 20)->default('primary');
            $table->string('kategori', 50);
            $table->unsignedInteger('harga');
            $table->string('satuan', 30)->default('per kg');
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Aktif', 'Non-aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
