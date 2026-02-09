<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('products', 'category_id')) {
            Schema::table('products', function (Blueprint $table): void {
                $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->nullOnDelete();
            });
        }

        $timestamp = now();
        $rootCategoryId = DB::table('categories')
            ->where('slug', 'uncategorized')
            ->value('id');

        if ($rootCategoryId === null) {
            $rootCategoryId = DB::table('categories')->insertGetId([
                'name' => 'Uncategorized',
                'slug' => 'uncategorized',
                'parent_id' => null,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        $leafCategoryId = DB::table('categories')
            ->where('slug', 'uncategorized-general')
            ->value('id');

        if ($leafCategoryId === null) {
            $leafCategoryId = DB::table('categories')->insertGetId([
                'name' => 'General',
                'slug' => 'uncategorized-general',
                'parent_id' => $rootCategoryId,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }

        DB::table('products')
            ->whereNull('category_id')
            ->update(['category_id' => $leafCategoryId]);
    }

    public function down(): void
    {
        if (!Schema::hasColumn('products', 'category_id')) {
            return;
        }

        Schema::table('products', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
