<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("
                ALTER TABLE transactions
                MODIFY COLUMN type ENUM(
                    'topup',
                    'payment',
                    'income',
                    'refund',
                    'escrow_release'
                )
            ");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement("
                ALTER TABLE transactions
                MODIFY COLUMN type ENUM(
                    'topup',
                    'payment',
                    'income'
                )
            ");
        }
    }
};