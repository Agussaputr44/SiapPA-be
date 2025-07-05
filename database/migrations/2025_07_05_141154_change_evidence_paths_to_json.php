<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('pengaduans', function (Blueprint $table) {
        $table->json('evidencePaths')->change();
    });
}

public function down()
{
    Schema::table('pengaduans', function (Blueprint $table) {
        $table->text('evidencePaths')->change(); // rollback ke text
    });
}

};
