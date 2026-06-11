<?php

namespace Database\Seeders;

use App\Models\ServicePackage;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class ServicePackageSeeder extends Seeder
{
    public function run(): void
    {
        $packagesBySubcategory = config('booking.default_packages', []);

        foreach ($packagesBySubcategory as $subName => $packages) {
            $sub = Subcategory::where('name', $subName)->first();
            if (! $sub) {
                continue;
            }

            foreach ($packages as [$name, $desc, $price]) {
                ServicePackage::updateOrCreate(
                    ['subcategory_id' => $sub->id, 'name' => $name],
                    ['description' => $desc, 'price' => $price]
                );
            }
        }
    }
}
