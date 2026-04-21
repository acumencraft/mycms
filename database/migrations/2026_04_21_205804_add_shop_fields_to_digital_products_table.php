<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            if (!Schema::hasColumn('digital_products', 'slug')) {
                $table->string('slug')->unique()->after('name');
            }
            if (!Schema::hasColumn('digital_products', 'short_description')) {
                $table->string('short_description', 500)->nullable()->after('slug');
            }
            if (!Schema::hasColumn('digital_products', 'category')) {
                $table->string('category', 50)->nullable()->after('description');
            }
            if (!Schema::hasColumn('digital_products', 'tags')) {
                $table->json('tags')->nullable()->after('category');
            }
            if (!Schema::hasColumn('digital_products', 'sale_price')) {
                $table->decimal('sale_price', 8, 2)->nullable()->after('price');
            }
            if (!Schema::hasColumn('digital_products', 'sale_ends_at')) {
                $table->timestamp('sale_ends_at')->nullable()->after('sale_price');
            }
            if (!Schema::hasColumn('digital_products', 'gallery_images')) {
                $table->json('gallery_images')->nullable()->after('image');
            }
            if (!Schema::hasColumn('digital_products', 'demo_url')) {
                $table->string('demo_url')->nullable()->after('gallery_images');
            }
            if (!Schema::hasColumn('digital_products', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('is_published');
            }
            if (!Schema::hasColumn('digital_products', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('digital_products', function (Blueprint $table) {
            $table->dropColumn([
                'slug', 'short_description', 'category', 'tags',
                'sale_price', 'sale_ends_at', 'gallery_images',
                'demo_url', 'is_featured',
            ]);
        });
    }
};
