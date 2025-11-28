<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('multiuploads', function (Blueprint $table) {
            $table->id();
            $table->string('filename', 250);
            $table->string('ref_table', 100)->nullable(); // ✅ MODIFIKASI
            $table->unsignedBigInteger('ref_id')->nullable(); // ✅ MODIFIKASI
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('multiuploads');
    }
};
