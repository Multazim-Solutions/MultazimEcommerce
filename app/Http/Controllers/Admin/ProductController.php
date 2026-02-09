<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductIndexRequest;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(ProductIndexRequest $request): View
    {
        $query = Product::query();

        $query = $this->applySearch($query, $request->search());
        $query = $this->applyStockFilter($query, $request->stock());
        $query = $this->applyActiveFilter($query, $request->active());
        $query = $this->applySort($query, $request->sort());

        $products = $query
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', [
            'products' => $products,
            'filters' => [
                'q' => $request->search(),
                'stock' => $request->stock(),
                'active' => $request->active(),
                'sort' => $request->sort(),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.products.create');
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $product = Product::create($request->validated());

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Product created');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('status', 'Product updated');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('status', 'Product deleted');
    }

    private function applySearch(Builder $query, ?string $search): Builder
    {
        if ($search === null) {
            return $query;
        }

        return $query->where(function (Builder $builder) use ($search): void {
            $builder
                ->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
        });
    }

    private function applyStockFilter(Builder $query, string $stockFilter): Builder
    {
        return match ($stockFilter) {
            'in_stock' => $query->where('stock_qty', '>', 0),
            'out_of_stock' => $query->where('stock_qty', '<=', 0),
            default => $query,
        };
    }

    private function applyActiveFilter(Builder $query, string $activeFilter): Builder
    {
        return match ($activeFilter) {
            'active' => $query->where('is_active', true),
            'inactive' => $query->where('is_active', false),
            default => $query,
        };
    }

    private function applySort(Builder $query, string $sort): Builder
    {
        return match ($sort) {
            'name_asc' => $query->orderBy('name'),
            'price_desc' => $query->orderByDesc('price'),
            'stock_low' => $query->orderBy('stock_qty'),
            default => $query->orderByDesc('id'),
        };
    }
}
