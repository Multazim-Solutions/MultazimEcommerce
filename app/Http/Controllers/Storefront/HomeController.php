<?php

declare(strict_types=1);

namespace App\Http\Controllers\Storefront;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\Schema;
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

        return view('storefront.home.index', [
            'promotionalSlides' => $this->promotionalSlides(),
            'featuredCategories' => $this->featuredCategories(),
            'productSections' => $this->productSections($products),
            'serviceHighlights' => $this->serviceHighlights(),
            'quickLinks' => $this->quickLinks(),
            'informationLinks' => $this->informationLinks(),
        ]);
    }

    /**
     * @return EloquentCollection<int, Category>
     */
    private function featuredCategories(): EloquentCollection
    {
        if (!Schema::hasTable('categories')) {
            return new EloquentCollection();
        }

        return Category::query()
            ->roots()
            ->withCount('children')
            ->orderBy('id')
            ->limit(8)
            ->get();
    }

    /**
     * @return array<int, array{image_url: string, heading: string, subheading: string}>
     */
    private function promotionalSlides(): array
    {
        return [
            [
                'image_url' => 'https://mohasagor.com.bd/public/storage/images/reseller_slider/c47UZMJLOFSZPAp3c6ZuzDL8omp0r8NKA7oOhNoB.png',
                'heading' => 'Seasonal Deals',
                'subheading' => 'Fresh picks and campaign bundles curated for daily shoppers.',
            ],
            [
                'image_url' => 'https://mohasagor.com.bd/public/storage/images/reseller_slider/aM07nJ0HX0Fdf5XCm8lqMdE4DEzN7cbJjxC1BStk.png',
                'heading' => 'Limited-Time Promotions',
                'subheading' => 'Catch high-demand products with short-run promotional pricing.',
            ],
            [
                'image_url' => 'https://mohasagor.com.bd/public/storage/images/reseller_slider/zaUkVOIdi0GV94vj0xZcoljDEOjTcGpanbDKKHN7.jpg',
                'heading' => 'New Arrival Spotlight',
                'subheading' => 'Explore latest arrivals across fashion, gadgets, and home essentials.',
            ],
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
