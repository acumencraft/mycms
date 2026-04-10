<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->string('contact_phone')->nullable()->after('testimonials_title');
            $table->string('contact_email')->nullable()->after('contact_phone');
            $table->string('contact_address')->nullable()->after('contact_email');
            $table->text('google_maps_embed')->nullable()->after('contact_address');
            $table->string('working_hours')->nullable()->after('google_maps_embed');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'contact_phone', 'contact_email',
                'contact_address', 'google_maps_embed', 'working_hours'
            ]);
        });
    }
};
