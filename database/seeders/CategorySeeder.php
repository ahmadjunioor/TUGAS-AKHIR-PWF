<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Service Elektronik' => ['Service AC', 'Service Kulkas', 'Service Mesin Cuci'],
            'Renovasi Bangunan' => ['Renovasi Rumah', 'Kontraktor Bangunan', 'Tukang Bangunan'],
            'Jasa Kebersihan' => ['Daily Cleaning', 'Deep Cleaning', 'Cuci Sofa'],
        ];

        foreach ($data as $categoryName => $subcategories) {
            $category = Category::firstOrCreate(['name' => $categoryName]);

            foreach ($subcategories as $subName) {
                Subcategory::firstOrCreate([
                    'category_id' => $category->id,
                    'name' => $subName,
                ]);
            }
        }
    }
}
