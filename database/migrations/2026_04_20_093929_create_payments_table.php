<?php
 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Status pembayaran
            $table->enum('status_pembayaran', [
                'pending',
                'waiting_confirmation',
                'paid',
                'cancelled'
            ])->default('pending')->after('bukti_pembayaran');
 
            // Batas waktu bayar
            $table->timestamp('batas_bayar')->nullable()->after('status_pembayaran');
 
            // Waktu upload bukti
            $table->timestamp('paid_at')->nullable()->after('batas_bayar');
 
            // Konfirmasi admin
            $table->timestamp('confirmed_at')->nullable()->after('paid_at');
            $table->foreignId('confirmed_by')
                ->nullable()
                ->after('confirmed_at')
                ->constrained('users')
                ->nullOnDelete();
        });
    }
 
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn([
                'status_pembayaran',
                'batas_bayar',
                'paid_at',
                'confirmed_at',
                'confirmed_by',
            ]);
        });
    }
};
 