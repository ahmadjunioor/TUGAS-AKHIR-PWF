<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('service_requests', 'subcategory_id')) {
                $table->foreignId('subcategory_id')->nullable()->after('category_id')->constrained()->nullOnDelete();
            }
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE service_requests MODIFY COLUMN status ENUM('open', 'bidding_closed', 'assigned', 'in_progress', 'awaiting_confirmation', 'completed', 'cancelled', 'disputed') DEFAULT 'open'");
        }
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            if (Schema::hasColumn('service_requests', 'subcategory_id')) {
                $table->dropForeign(['subcategory_id']);
                $table->dropColumn('subcategory_id');
            }
        });

        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("ALTER TABLE service_requests MODIFY COLUMN status ENUM('open', 'bidding_closed', 'assigned', 'in_progress', 'completed', 'cancelled', 'disputed') DEFAULT 'open'");
        }
    }
};
