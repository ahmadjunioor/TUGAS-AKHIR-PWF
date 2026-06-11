<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ServicePackageSeeder::class,
            SuperAdminSeeder::class,
        ]);

        if (\Laravolt\Indonesia\Models\City::count() === 0) {
            $this->command->info('Seeding Indonesia regions...');
            \Illuminate\Support\Facades\Artisan::call('laravolt:indonesia:seed');
        }
    }
}
