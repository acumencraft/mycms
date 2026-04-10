<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table("guides", function (Blueprint $table) {
            $table->string("youtube_url")->nullable()->after("content");
            $table->string("cover_image")->nullable()->after("youtube_url");
        });
        Schema::table("publications", function (Blueprint $table) {
            $table->string("cover_image")->nullable()->after("excerpt");
        });
    }
    public function down(): void {
        Schema::table("guides", function (Blueprint $table) {
            $table->dropColumn(["youtube_url", "cover_image"]);
        });
        Schema::table("publications", function (Blueprint $table) {
            $table->dropColumn("cover_image");
        });
    }
};
