<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('storefront.categories.index', [
            'rootCategories' => $this->rootCategories(),
        ]);
    }

    /**
     * @return EloquentCollection<int, Category>
     */
    private function rootCategories(): EloquentCollection
    {
        if (!Schema::hasTable('categories')) {
            return new EloquentCollection();
        }

        return Category::query()
            ->roots()
            ->with([
                'children' => static function ($query): void {
                    $query->orderBy('name');
                },
            ])
            ->withCount('children')
            ->orderBy('id')
            ->get();
    }
}
