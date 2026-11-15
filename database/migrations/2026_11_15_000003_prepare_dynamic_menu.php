<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('price')->nullable()->change();
            $table->unsignedInteger('reference_price')->nullable();
            $table->text('ingredients')->nullable();
            $table->string('reference_source')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['reference_price', 'ingredients', 'reference_source']);
        });
    }
};
