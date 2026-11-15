<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('homepage_contents', function (Blueprint $table) {
            $table->boolean('hours_provisional')->default(false);
            $table->string('hours_source')->nullable();
            $table->string('wolt_url')->nullable();
            $table->string('foodora_url')->nullable();
            $table->string('neotaste_url')->nullable();
        });
        Schema::table('offers', function (Blueprint $table) {
            $table->unsignedInteger('original_price')->nullable()->change();
            $table->unsignedInteger('offer_price')->nullable()->change();
            $table->string('source_url')->nullable();
            $table->text('redemption_conditions')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('offers', function (Blueprint $table) {
            $table->dropColumn(['source_url', 'redemption_conditions']);
            $table->unsignedInteger('original_price')->nullable(false)->change();
            $table->unsignedInteger('offer_price')->nullable(false)->change();
        });
        Schema::table('homepage_contents', fn (Blueprint $table) => $table->dropColumn(['hours_provisional', 'hours_source', 'wolt_url', 'foodora_url', 'neotaste_url']));
    }
};
