<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('homepage_contents', function (Blueprint $table) {
            $table->longText('imprint_content')->nullable();
            $table->longText('privacy_content')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('homepage_contents', fn (Blueprint $table) => $table->dropColumn(['imprint_content', 'privacy_content']));
    }
};
