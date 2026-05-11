<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('page_title')->nullable()->after('title');
            $table->string('page_subtitle')->nullable()->after('page_title');
            $table->integer('items_count')->default(6)->after('page_subtitle');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['page_title', 'page_subtitle', 'items_count']);
        });
    }
};
