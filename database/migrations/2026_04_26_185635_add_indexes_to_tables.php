<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->index('created_at');
            $table->index('page');
            $table->index(['ip', 'created_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index(['status', 'created_at']);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->index(['user_id', 'status']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->index(['user_id', 'created_at']);
        });

        Schema::table('project_messages', function (Blueprint $table) {
            $table->index(['project_id', 'created_at']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index(['publication_id', 'is_approved']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
            $table->dropIndex(['page']);
            $table->dropIndex(['ip', 'created_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status', 'created_at']);
        });

        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'status']);
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'created_at']);
        });

        Schema::table('project_messages', function (Blueprint $table) {
            $table->dropIndex(['project_id', 'created_at']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['publication_id', 'is_approved']);
            $table->dropIndex(['created_at']);
        });
    }
};
