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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->enum('garment_type',['shalwar_qameez','kurta_pajama','waistcoat','coat_pant','kids_wear','other'])->default('shalwar_qameez');
            // tandard kpk measurements in inchies
            $table->decimal('length',5,2)->nullable();
            $table->decimal('chest',5,2)->nullable();
            $table->decimal('waist',5,2)->nullable();
            $table->decimal('hips',5,2)->nullable();
            $table->decimal('shoulder',5,2)->nullable();
            $table->decimal('sleeve_length',5,2)->nullable();
            $table->decimal('collar',5,2)->nullable();
            $table->decimal('armhole',5,2)->nullable();
            $table->decimal('bicep',5,2)->nullable();
            $table->decimal('shalwar_length',5,2)->nullable();
            $table->decimal('paincha',5,2)->nullable();
            $table->text('style_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
