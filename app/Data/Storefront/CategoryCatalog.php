<?php

declare(strict_types=1);

namespace App\Data\Storefront;

final class CategoryCatalog
{
    /**
     * @var array<string, array<string, list<string>>>
     */
    private const TREE = [
        'Winter' => [
            'Hoodies' => [
                "Women's Solid Hoodie",
                "Men's Islamic Hoodie",
                "Men's Solid Hoodie",
                'ladies Hoodies',
                "Men's Classic Hoodie",
                'Couple Hoodie',
                'Kids Hoodie',
            ],
            'Sweatshirt' => [],
            'Jecket' => [],
            'Winter combo' => [],
            'Trouser' => [],
            'Full Sleeve T-Shirt' => [],
        ],
        "Men's Fashion" => [
            'Panjabi' => [
                'Premium Panjabi',
                'Luxury Panjabi',
                'Basic Panjabi',
                'Premium Pajama',
                'Kabli Set',
                'KIds Punjabi',
                'Karchupi Panjabi',
                'Combo Set',
            ],
            'T-Shirt' => [
                'Half Sleeve T-Shirt',
                'Jersey Fabrics',
                'Cotton Fabrics',
                'Full Sleeve T-Shirt',
                'Islamic',
                'Drop Shoulder',
                'Kids T Shirt',
                'Combo T - shirt',
            ],
            'Shirts' => [
                'Baby shirts',
                'Polo Shirts',
                'Casual solid Shirt',
                "Men's Stylish Casual Shirt",
                'Formal Shirt',
                'Double pocket shirt',
                'Half Sleeve',
                'Premium full Sleeve Shirt',
                'Cotton full Sleeve Check Shirt',
                'Luxury Print Shirt',
                'Check - Shirt',
            ],
            'Pants' => [
                'Jeans Pant',
                'Gabardine Pant.',
                'Joggers',
                'Trouser',
                'Formal Pant',
            ],
            'Cotton Katua' => [
                'Katua',
            ],
            "Men's Accessories" => [
                'Watch',
                'Belt',
                'Wallet',
                'Grooming',
                'Cap Item',
            ],
            'Jersey & Sports' => [],
        ],
        "Women's Fashion" => [
            'Saree' => [
                'Silk Saree',
                'Cotton Saree',
                'Jamdani Saree',
                'Tangail Saree',
                'Lawn / Printed Saree',
                'Georgette & Chiffon Saree',
                'Combo-Set',
            ],
            'Salwar-Kameez' => [
                '3 Pcs',
                '2 Pcs',
                'Kurti',
            ],
            'Borka' => [
                'Borka & Hijab',
                'Only Hijab',
                'Abaya',
                'Khimar',
                'Palazzo Khimar Set',
            ],
            "Women's Accessories" => [
                'Watch.',
                "Women' Bag",
            ],
            'Jewellery' => [
                'Earring',
                'Baslate',
                'Nose Pin',
                'Ring',
                'Pendant',
                'Necklace',
            ],
            'Cosmetics' => [
                'Skin Care',
                'Makeup',
                'Hair Care',
            ],
            'Ladies Bag' => [],
            'Girls Wear' => [
                'Ladies T - Shirt',
                'Ladies Dropsolder',
                'Mexi',
            ],
        ],
        'Home & Lifestyle' => [
            'Bed Sheet' => [
                'Cotton Bed Sheet (Bangla)',
                'panel bed sheet (3pcs)',
                'Cotton Design Bedsheet (4pcs Set)',
                'Panel Bed sheet (8 pieces)',
                'China Premium 3D Design Bed Sheet',
                'Water Proof 3d Bed Shit',
            ],
            'Home Appliance' => [
                'Table Clock',
                '3D Design Mug',
                '3d curtain',
                'Table cloth',
                'Tripod And Stand',
                'Wall Decor',
            ],
            'Health & Beauty' => [
                'Organic Food',
                'Eexercise item',
                'Fragrances',
                'Personal Care',
                "Men's Care",
            ],
            'Kitchen & Dining' => [
                'Kitchen Item',
                'Kitchen',
                'Bottle / Mug / Cup',
                'Grinders',
                'Electric Kettle',
            ],
            'Islamic Corner' => [
                'Tupi',
                'Ator',
                'Jainamaj',
                'Others Islamic Product',
                'Cloth item',
            ],
            'Rain item' => [],
            'Sunglasses' => [
                'Unisex Sunglass',
                'Ladies Sunglass',
                "Gent's Sunglass",
            ],
            'Bag' => [
                'Student Bag',
                'Hands Parts Bag',
                'Travel Bag',
                "Women's Bags",
                "Men's Bag",
            ],
            'Watches' => [
                'Premium Watch.',
                'Basic Watch',
                'Ladies Watch',
                'Couple Watch',
                'Smart Watch',
                'Luxury Watch',
                'KIds watch',
            ],
        ],
        'Gadgets & Electronics' => [
            'Mobile Accessories' => [
                'Earbuds & Bluetooth',
                'Power Bank',
                'Video Kit',
                'Headphone',
                'Cable & charger',
                'Mobile Phone',
            ],
            'Content Tools' => [
                'Tripod & Stand',
                'Camera',
                'Microphone',
            ],
            'Electronics' => [
                'Electronic Device',
                'Electronic Item',
                'Router',
            ],
            'Shaver & Trimmer' => [
                'Kemei',
            ],
            'Speaker' => [
                'Wareless Speaker',
                'Mini -Speaker',
                'Computer Speaker',
            ],
            'Fan Item' => [
                'Air Cooler Fan',
                'Mini Fan',
                'rechargeable fan',
            ],
            'Computer Item' => [
                'Mouse & Key-Board',
                'Computer accessories',
                'Awei Brand',
            ],
        ],
        'Kids Zone' => [
            'Transparent Toys' => [],
            'Baby Item' => [],
            'Robot Car' => [],
            'Baby Toy' => [],
            'Children Clothing' => [
                'Kids T-shirt',
                'babysPunjabi',
                'Kids Shirt',
            ],
        ],
        'Customize & Gift' => [
            'Gift Item' => [
                'Sharee Combo',
            ],
            'Customize Item' => [
                'Crest',
                'Bottle & Mug',
                'Clothes',
                'Pen & Key-Ring',
                'ID Card & Diary',
            ],
        ],
        'Offer' => [
            'Mystery Box' => [],
            'Stock Clearance Sale' => [],
            'Big Offer' => [],
        ],
        "Other's" => [
            "Other's" => [],
            'Combo Pack' => [
                'Gadget',
                'Clothing',
                'Mixing',
            ],
            'Couple' => [],
        ],
    ];

    /**
     * @return array<string, array<string, list<string>>>
     */
    public static function tree(): array
    {
        return self::TREE;
    }

    /**
     * @return list<array{root: string, subcategory: string, product_names: list<string>}>
     */
    public static function subcategoryEntries(): array
    {
        $entries = [];

        foreach (self::TREE as $rootCategoryName => $subcategories) {
            foreach ($subcategories as $subcategoryName => $productNames) {
                $entries[] = [
                    'root' => $rootCategoryName,
                    'subcategory' => $subcategoryName,
                    'product_names' => $productNames,
                ];
            }
        }

        return $entries;
    }

    /**
     * @return array{root: string, subcategory: string, product_names: list<string>}
     */
    public static function randomSubcategoryEntry(): array
    {
        $entries = self::subcategoryEntries();
        $maxIndex = count($entries) - 1;

        return $entries[random_int(0, $maxIndex)];
    }

    /**
     * @return list<string>
     */
    public static function allProductNames(): array
    {
        $names = [];

        foreach (self::subcategoryEntries() as $entry) {
            foreach ($entry['product_names'] as $productName) {
                $names[] = $productName;
            }
        }

        return array_values(array_unique($names));
    }

    private function __construct()
    {
    }
}
