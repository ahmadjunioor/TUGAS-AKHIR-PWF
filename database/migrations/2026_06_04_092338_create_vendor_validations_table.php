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
        Schema::create('vendor_validations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_profile_id')->constrained()->cascadeOnDelete();
            $table->string('ktp_path')->nullable();
            $table->string('selfie_ktp_path')->nullable();
            $table->string('skck_path')->nullable();
            $table->string('domicile_path')->nullable();
            $table->string('kk_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_validations');
    }
};
