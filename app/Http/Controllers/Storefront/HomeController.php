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
            ->limit(48)
            ->get();

        return view('storefront.home.index', [
            'menuItems' => $this->menuItems(),
            'categoryItems' => $this->categoryItems(),
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
            ['label' => 'Winter', 'url' => '#'],
            ['label' => "Men's Fashion", 'url' => '#'],
            ['label' => "Women's Fashion", 'url' => '#'],
            ['label' => 'Home & Lifestyle', 'url' => '#'],
            ['label' => 'Gadgets & Electronics', 'url' => '#'],
            ['label' => 'Kids Zone', 'url' => '#'],
            ['label' => 'Customize & Gift', 'url' => '#'],
            ['label' => 'Offer', 'url' => '#'],
            ['label' => "Other's", 'url' => '#'],
        ];
    }

    /**
     * @return array<int, array{label: string, url: string}>
     */
    private function categoryItems(): array
    {
        return [
            ['label' => 'Mobile Accessories', 'url' => '#'],
            ['label' => 'T-Shirt', 'url' => '#'],
            ['label' => 'Watches', 'url' => '#'],
            ['label' => 'Islamic Corner', 'url' => '#'],
            ['label' => 'Shirts', 'url' => '#'],
            ['label' => 'Kitchen & Dining', 'url' => '#'],
            ['label' => 'Bag', 'url' => '#'],
            ['label' => 'Health & Beauty', 'url' => '#'],
            ['label' => 'Content Tools', 'url' => '#'],
            ['label' => 'Electronics', 'url' => '#'],
            ['label' => 'Speaker', 'url' => '#'],
            ['label' => 'Home Appliance', 'url' => '#'],
            ['label' => 'Bed Sheet', 'url' => '#'],
            ['label' => 'Transparent Toys', 'url' => '#'],
            ['label' => 'Borka', 'url' => '#'],
            ['label' => 'Shaver & Trimmer', 'url' => '#'],
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
            ['label' => 'Order Tracking', 'url' => '#'],
            ['label' => 'Login', 'url' => route('login')],
            ['label' => 'Register', 'url' => route('register')],
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
