<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('icon', 50)->default('fa-box-open');   // class Font Awesome, contoh: fa-tshirt
            $table->string('warna', 20)->default('primary');      // warna badge/icon: primary, info, warning, dst
            $table->unsignedInteger('harga');                     // disimpan angka murni, format Rp ditangani di view
            $table->string('satuan', 20)->default('kg');          // kg, pcs, m2, psg, dst
            $table->unsignedInteger('estimasi_hari')->default(1);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Aktif', 'Non-aktif'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
