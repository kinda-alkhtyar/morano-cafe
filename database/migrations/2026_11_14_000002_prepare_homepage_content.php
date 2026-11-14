<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->string('homepage_slot')->nullable()->unique();
        });
        $images = [
            'pinsa' => 'products/snacks/pinsa-margherita.png',
            'salate' => 'products/salads/caesar-salat.png',
            'sandwiches' => 'products/sandwiches/sandwich-gegrilltes-gemuese.png',
            'desserts' => 'products/keks/new-york-cheesecake.png',
        ];
        foreach (\App\Support\HomepageCategories::LABELS as $slot => $name) {
            $record = DB::table('categories')->where('slug', $slot)->first();
            if ($record) {
                DB::table('categories')->where('id', $record->id)->update(['homepage_slot' => $slot]);
            } else {
                DB::table('categories')->insert([
                    'name' => $name, 'slug' => $slot, 'homepage_slot' => $slot,
                    'image_path' => $images[$slot] ?? null, 'sort_order' => array_search($slot, array_keys(\App\Support\HomepageCategories::LABELS)),
                    'is_active' => true, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }
        }
        Schema::create('homepage_contents', function (Blueprint $table) {
            $table->id();
            $table->string('about_heading')->nullable();
            $table->text('about_text')->nullable();
            $table->string('about_image')->nullable();
            $table->text('highlights_empty_text')->nullable();
            $table->text('offers_empty_text')->nullable();
            $table->text('address')->nullable();
            $table->json('hours')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('map_embed_url')->nullable();
            $table->timestamps();
        });
        DB::table('homepage_contents')->insert([
            'id' => 1, 'about_heading' => 'Zeit für einen Kaffee.',
            'about_text' => 'Ob auf einen Kaffee zwischendurch oder zum gemütlichen Zusammensitzen: Bei uns in Wien bist du willkommen. Dazu gibt es Kuchen und eine Auswahl an kleinen Speisen.',
            'about_image' => 'offers/coffee-cake.webp',
            'highlights_empty_text' => 'Unsere Empfehlungen findest du in der Speisekarte.',
            'offers_empty_text' => 'Derzeit sind keine Angebote veröffentlicht.',
            'created_at' => now(), 'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('homepage_contents');
        Schema::table('categories', fn (Blueprint $table) => $table->dropColumn('homepage_slot'));
    }
};
