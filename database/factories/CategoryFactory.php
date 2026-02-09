<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name).'-'.fake()->unique()->numerify('###'),
            'parent_id' => null,
        ];
    }

    public function subcategory(?Category $parent = null): self
    {
        return $this->state(function () use ($parent): array {
            $resolvedParent = $parent ?? Category::factory()->create();
            $name = fake()->unique()->words(2, true);

            return [
                'name' => $name,
                'slug' => $resolvedParent->slug.'-'.Str::slug($name).'-'.fake()->unique()->numerify('###'),
                'parent_id' => $resolvedParent->id,
            ];
        });
    }
}
