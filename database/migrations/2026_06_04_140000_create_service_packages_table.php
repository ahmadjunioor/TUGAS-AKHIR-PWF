<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subcategory_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::table('service_requests', function (Blueprint $table) {
            $table->json('booking_details')->nullable()->after('max_budget');
            $table->decimal('estimated_total', 12, 2)->nullable()->after('booking_details');
            $table->timestamp('scheduled_at')->nullable()->after('estimated_total');
        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['booking_details', 'estimated_total', 'scheduled_at']);
        });
        Schema::dropIfExists('service_packages');
    }
};
