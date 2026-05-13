<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->integer('portfolio_items_count')->default(6)->after('portfolio_subtitle');
            $table->integer('services_items_count')->default(6)->after('services_subtitle');
            $table->integer('testimonials_items_count')->default(3)->after('testimonials_title');
            $table->string('blog_title')->nullable()->after('testimonials_items_count');
            $table->string('blog_subtitle')->nullable()->after('blog_title');
            $table->integer('blog_items_count')->default(3)->after('blog_subtitle');
            $table->boolean('show_portfolio')->default(true)->after('blog_items_count');
            $table->boolean('show_services')->default(true)->after('show_portfolio');
            $table->boolean('show_testimonials')->default(true)->after('show_services');
            $table->boolean('show_blog')->default(false)->after('show_testimonials');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'portfolio_items_count', 'services_items_count',
                'testimonials_items_count', 'blog_title', 'blog_subtitle',
                'blog_items_count', 'show_portfolio', 'show_services',
                'show_testimonials', 'show_blog',
            ]);
        });
    }
};
