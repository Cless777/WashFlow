<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 20)->unique();   // TRX001, TRX002, dst
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->unsignedInteger('jumlah_dibayar')->default(0);
            $table->enum('metode', ['Cash', 'Transfer', 'QRIS'])->nullable();
            $table->enum('status', ['Lunas', 'DP', 'Belum Bayar'])->default('Belum Bayar');
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
