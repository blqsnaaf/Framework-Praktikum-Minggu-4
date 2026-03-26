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
        Schema::create('jenis_transaksi', function (Blueprint $table) {
            $table->id(); // Id Jenis Transaksi
            $table->enum('jenis_transaksi', ['Reimbursement', 'Pengembalian']); // Jenis Transaksi
            $table->string('keterangan'); // Keterangan Transaksi
            $table->date('tanggal_lahir'); // Tanggal lahir
            $table->string('foto_ktp'); // upload e-ktp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_transaksi');
    }
};
