<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('style_options', function (Blueprint $table) {
               $table->id();
            $table->foreignId('style_category_id')->constrained()->cascadeOnDelete();
            $table->string('name');            // e.g. Peshawari Collar, Mandarin Collar
            $table->string('code');            // e.g. peshawari, mandarin
            $table->string('icon_path')->nullable();   // path to SVG asset in /storage, e.g. icons/collars/peshawari.svg
            $table->string('swatch_color', 7)->nullable(); // quick-render hex fallback if icon not loaded, e.g. #0F5C56
            $table->text('description')->nullable();
            $table->decimal('extra_price', 8, 2)->default(0.00); // some styles (e.g. embroidery) cost more
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->unique(['style_category_id', 'code']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('style_options');
    }
};
