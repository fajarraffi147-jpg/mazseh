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
        Schema::table('katalog_mobil', function (Blueprint $table) {
            $table->string('slug', 100)->nullable()->unique()->after('merk_model');
            $table->unsignedSmallInteger('tahun')->default(2024)->after('slug');
            $table->string('transmisi', 30)->default('Otomatis')->after('tahun');
            $table->unsignedTinyInteger('jumlah_kursi')->default(7)->after('transmisi');
            $table->string('bahan_bakar', 30)->default('Bensin')->after('jumlah_kursi');
            $table->string('kota', 50)->default('Semarang')->after('bahan_bakar');
            $table->string('foto_mobil', 255)->nullable()->after('kota');
            $table->string('label', 50)->nullable()->after('foto_mobil');
            $table->text('deskripsi')->nullable()->after('label');
            $table->json('fitur')->nullable()->after('deskripsi');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('role');
            $table->string('city', 50)->nullable()->after('phone');
            $table->text('address')->nullable()->after('city');
            $table->string('sim_number', 50)->nullable()->after('address');
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->string('kode_booking', 30)->nullable()->unique()->after('id_transaksi');
            $table->string('waktu_ambil', 10)->default('09:00')->after('tanggal_selesai');
            $table->string('metode_pengambilan', 50)->default('Ambil di pool MAZSEH')->after('waktu_ambil');
            $table->string('opsi_pengemudi', 30)->default('Lepas kunci')->after('metode_pengambilan');
            $table->text('catatan')->nullable()->after('alasan_batal');
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->string('metode_pembayaran', 50)->default('Transfer bank')->after('jumlah_bayar');
            $table->string('referensi_pembayaran', 100)->nullable()->after('metode_pembayaran');
            $table->string('bukti_bayar', 255)->nullable()->after('referensi_pembayaran');
        });

        Schema::table('document_pelanggan', function (Blueprint $table) {
            $table->string('file_ktp', 255)->nullable()->change();
            $table->string('file_sim', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katalog_mobil', function (Blueprint $table) {
            $table->dropColumn([
                'slug',
                'tahun',
                'transmisi',
                'jumlah_kursi',
                'bahan_bakar',
                'kota',
                'foto_mobil',
                'label',
                'deskripsi',
                'fitur',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'city', 'address', 'sim_number']);
        });

        Schema::table('transaksi', function (Blueprint $table) {
            $table->dropColumn([
                'kode_booking',
                'waktu_ambil',
                'metode_pengambilan',
                'opsi_pengemudi',
                'catatan',
            ]);
        });

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropColumn([
                'metode_pembayaran',
                'referensi_pembayaran',
                'bukti_bayar',
            ]);
        });

        Schema::table('document_pelanggan', function (Blueprint $table) {
            $table->string('file_ktp', 255)->nullable(false)->change();
            $table->string('file_sim', 255)->nullable(false)->change();
        });
    }
};
