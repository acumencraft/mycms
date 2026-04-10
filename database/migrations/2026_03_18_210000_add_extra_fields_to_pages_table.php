<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('hero_title')->nullable()->after('status');
            $table->text('hero_subtitle')->nullable()->after('hero_title');
            $table->string('hero_image')->nullable()->after('hero_subtitle');
            $table->string('hero_button_text')->nullable()->after('hero_image');
            $table->string('hero_button_url')->nullable()->after('hero_button_text');
            $table->string('portfolio_title')->nullable()->after('hero_button_url');
            $table->text('portfolio_subtitle')->nullable()->after('portfolio_title');
            $table->string('services_title')->nullable()->after('portfolio_subtitle');
            $table->text('services_subtitle')->nullable()->after('services_title');
            $table->string('features_title')->nullable()->after('services_subtitle');
            $table->text('features_subtitle')->nullable()->after('features_title');
            $table->string('testimonials_title')->nullable()->after('features_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'hero_title', 'hero_subtitle', 'hero_image',
                'hero_button_text', 'hero_button_url',
                'portfolio_title', 'portfolio_subtitle',
                'services_title', 'services_subtitle',
                'features_title', 'features_subtitle',
                'testimonials_title',
            ]);
        });
    }
};
