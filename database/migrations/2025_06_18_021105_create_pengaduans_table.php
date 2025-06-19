<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengaduansTable extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('namaKorban');
            $table->text('alamat');
            $table->text('aduan');
            $table->text('harapan');
            $table->timestamps(); 

            // Enum status
            $table->enum('status', ['terkirim', 'diproses', 'selesai'])->default('terkirim');

            // Foreign key ke users
            $table->unsignedBigInteger('pelapor');
            $table->foreign('pelapor')->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('createdAt')->useCurrent();
            $table->timestamp('updatedAt')->nullable();

            // Evidence (gunakan JSON array)
            $table->json('evidenceUrls')->nullable();
            $table->json('evidencePaths')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
}
