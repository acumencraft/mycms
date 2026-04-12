<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('website')->nullable()->after('country');
            $table->string('industry')->nullable()->after('website');
            $table->string('budget_range')->nullable()->after('industry');
            $table->enum('status', ['active', 'inactive', 'lead', 'vip'])->default('active')->after('budget_range');
            $table->text('notes')->nullable()->after('status');
            $table->string('social_linkedin')->nullable()->after('notes');
            $table->string('social_facebook')->nullable()->after('social_linkedin');
            $table->string('timezone')->nullable()->after('social_facebook');
            $table->date('birthday')->nullable()->after('timezone');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn([
                'website', 'industry', 'budget_range', 'status',
                'notes', 'social_linkedin', 'social_facebook',
                'timezone', 'birthday',
            ]);
        });
    }
};
