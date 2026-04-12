<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['industry', 'budget_range', 'notes', 'timezone']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['bio']);
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('industry')->nullable();
            $table->string('budget_range')->nullable();
            $table->text('notes')->nullable();
            $table->string('timezone')->nullable();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('bio')->nullable();
        });
    }
};
