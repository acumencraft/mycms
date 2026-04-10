<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table("orders", function (Blueprint $table) {
            $table->string("timeline")->nullable()->after("website_type");
            $table->string("budget_range")->nullable()->after("timeline");
            $table->text("project_description")->nullable()->after("budget_range");
            $table->text("additional_requirements")->nullable()->after("project_description");
        });
    }
    public function down(): void {
        Schema::table("orders", function (Blueprint $table) {
            $table->dropColumn(["timeline", "budget_range", "project_description", "additional_requirements"]);
        });
    }
};
