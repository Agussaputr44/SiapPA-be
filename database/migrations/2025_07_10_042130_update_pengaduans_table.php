<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Ubah enum kategoriKekerasan
            $table->enum('kategoriKekerasan', [
                'kekerasan_fisik',
                'kekerasan_seksual',
                'kekerasan_psikis',
                'kekerasan_ekonomi',
                'kekerasan_sosial'
            ])->default('kekerasan_fisik')->change();

            // Tambah kolom korban
            $table->enum('korban', [
                'anak_laki_laki',
                'anak_perempuan',
                'perempuan'
            ])->default('perempuan')->after('kategoriKekerasan');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduans', function (Blueprint $table) {
            // Balikkan enum kategori ke isi sebelumnya
            $table->enum('kategoriKekerasan', [
                'kekerasan_fisik',
                'kekerasan_seksual',
                'kekerasan_lainnya'
            ])->default('kekerasan_fisik')->change();

            // Hapus kolom korban
            $table->dropColumn('korban');
        });
    }
};
