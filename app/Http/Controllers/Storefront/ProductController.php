<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Data\Storefront\ProductCatalogFilters;
use App\Enums\ProductSortOption;
use App\Enums\ProductStockFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Storefront\ProductCatalogRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(ProductCatalogRequest $request): View
    {
        $filters = $request->filters();
        $products = $this->buildCatalogQuery($filters)
            ->paginate(12)
            ->withQueryString();

        return view('storefront.products.index', [
            'products' => $products,
            'filters' => $filters,
            'sortOptions' => ProductSortOption::cases(),
            'stockOptions' => ProductStockFilter::cases(),
        ]);
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);

        $product->load('images');

        return view('storefront.products.show', [
            'product' => $product,
        ]);
    }

    private function buildCatalogQuery(ProductCatalogFilters $filters): Builder
    {
        $query = Product::query()
            ->active()
            ->with('images')
            ->search($filters->search);

        $query = match ($filters->stock) {
            ProductStockFilter::All => $query,
            ProductStockFilter::InStock => $query->where('stock_qty', '>', 0),
            ProductStockFilter::OutOfStock => $query->where('stock_qty', '<=', 0),
        };

        return match ($filters->sort) {
            ProductSortOption::Newest => $query->orderByDesc('id'),
            ProductSortOption::PriceLowToHigh => $query->orderBy('price'),
            ProductSortOption::PriceHighToLow => $query->orderByDesc('price'),
            ProductSortOption::NameAZ => $query->orderBy('name'),
        };
    }
}
