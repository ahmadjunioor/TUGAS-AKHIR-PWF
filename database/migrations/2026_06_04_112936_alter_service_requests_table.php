<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->decimal('max_budget', 12, 2)->nullable()->after('description');
            $table->string('lat')->nullable()->after('city');
            $table->string('lng')->nullable()->after('lat');
        });
        
        // Use raw statement for enum change to avoid doctrine/dbal requirement if any issues
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE service_requests MODIFY COLUMN status ENUM('open', 'bidding_closed', 'assigned', 'in_progress', 'completed', 'cancelled', 'disputed') DEFAULT 'open'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropColumn(['max_budget', 'lat', 'lng']);
        });
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE service_requests MODIFY COLUMN status ENUM('open', 'taken', 'in_progress', 'completed', 'cancelled') DEFAULT 'open'");
        }
    }
};
