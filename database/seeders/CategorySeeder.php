<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Data\Storefront\CategoryCatalog;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (CategoryCatalog::tree() as $rootCategoryName => $subcategories) {
            $rootCategory = Category::query()->updateOrCreate(
                ['slug' => Str::slug($rootCategoryName)],
                [
                    'name' => $rootCategoryName,
                    'parent_id' => null,
                ],
            );

            foreach (array_keys($subcategories) as $subcategoryName) {
                Category::query()->updateOrCreate(
                    ['slug' => $this->subcategorySlug($rootCategoryName, $subcategoryName)],
                    [
                        'name' => $subcategoryName,
                        'parent_id' => $rootCategory->id,
                    ],
                );
            }
        }
    }

    private function subcategorySlug(string $rootCategoryName, string $subcategoryName): string
    {
        return Str::slug($rootCategoryName).'-'.Str::slug($subcategoryName);
    }
}
