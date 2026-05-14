<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('hero_video')->nullable()->after('hero_image');
            $table->enum('hero_media_type', ['image', 'video'])->default('image')->after('hero_video');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn(['hero_video', 'hero_media_type']);
        });
    }
};
