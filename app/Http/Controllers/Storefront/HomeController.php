<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->active()
            ->with(['images' => static function ($query): void {
                $query->orderBy('sort_order');
            }])
            ->orderByDesc('id')
            ->limit(64)
            ->get();

        $heroProducts = $products->filter(
            static fn (Product $product): bool => $product->images->isNotEmpty()
        )->take(6)->values();

        $categoryProducts = $products->take(16)->values();

        return view('storefront.home.index', [
            'menuItems' => $this->menuItems(),
            'heroProducts' => $heroProducts,
            'categoryProducts' => $categoryProducts,
            'productSections' => $this->productSections($products),
            'serviceHighlights' => $this->serviceHighlights(),
            'quickLinks' => $this->quickLinks(),
            'informationLinks' => $this->informationLinks(),
        ]);
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function menuItems(): array
    {
        return [
            ['label' => 'Winter', 'url' => route('storefront.products.index', ['q' => 'winter'])],
            ['label' => "Men's Fashion", 'url' => route('storefront.products.index', ['q' => 'men'])],
            ['label' => "Women's Fashion", 'url' => route('storefront.products.index', ['q' => 'women'])],
            ['label' => 'Home & Lifestyle', 'url' => route('storefront.products.index', ['q' => 'home'])],
            ['label' => 'Gadgets & Electronics', 'url' => route('storefront.products.index', ['q' => 'electronics'])],
            ['label' => 'Kids Zone', 'url' => route('storefront.products.index', ['q' => 'kids'])],
            ['label' => 'Customize & Gift', 'url' => route('storefront.products.index', ['q' => 'gift'])],
            ['label' => 'Offer', 'url' => route('storefront.products.index')],
            ['label' => "Other's", 'url' => route('storefront.products.index')],
        ];
    }

    /**
     * @param EloquentCollection<int, Product> $products
     * @return array<int, array{title: string, products: EloquentCollection<int, Product>}>
     */
    private function productSections(EloquentCollection $products): array
    {
        $fallbackProducts = $products->take(8)->values();

        return [
            [
                'title' => 'Flash Sale Products',
                'products' => $this->sectionProducts($products->slice(0, 8)->values(), $fallbackProducts),
            ],
            [
                'title' => 'Hot Selling Products',
                'products' => $this->sectionProducts($products->slice(8, 8)->values(), $fallbackProducts),
            ],
            [
                'title' => 'New Arrival Products',
                'products' => $this->sectionProducts($products->slice(16, 8)->values(), $fallbackProducts),
            ],
            [
                'title' => 'Top Selling Products',
                'products' => $this->sectionProducts($products->slice(24, 8)->values(), $fallbackProducts),
            ],
        ];
    }

    /**
     * @param EloquentCollection<int, Product> $products
     * @param EloquentCollection<int, Product> $fallbackProducts
     * @return EloquentCollection<int, Product>
     */
    private function sectionProducts(EloquentCollection $products, EloquentCollection $fallbackProducts): EloquentCollection
    {
        if ($products->isNotEmpty()) {
            return $products;
        }

        return $fallbackProducts;
    }

    /**
     * @return array<int, array{title: string, description: string}>
     */
    private function serviceHighlights(): array
    {
        return [
            [
                'title' => 'High-quality Goods',
                'description' => 'Enjoy top quality items for less',
            ],
            [
                'title' => '24/7 Live chat',
                'description' => 'Get instant assistance whenever you need it',
            ],
            [
                'title' => 'Express Shipping',
                'description' => 'Fast & reliable delivery options',
            ],
            [
                'title' => 'Secure Payment',
                'description' => 'Multiple safe payment methods',
            ],
        ];
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function quickLinks(): array
    {
        return [
            ['label' => 'Products', 'url' => route('storefront.products.index')],
            ['label' => 'Cart', 'url' => route('storefront.cart.index')],
            ['label' => 'Login', 'url' => route('login')],
        ];
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function informationLinks(): array
    {
        return [
            ['label' => 'Customer Policy & Handbook', 'url' => '#'],
            ['label' => 'Multazim Solutions', 'url' => '#'],
        ];
    }
}
