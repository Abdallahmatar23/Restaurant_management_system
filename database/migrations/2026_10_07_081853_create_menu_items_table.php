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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->default('dashboard/assets/img/drinks.jpg');
            $table->decimal('price', total:8, places:2);
            $table->enum('availability',['available','unavailable'])->default('available');
            $table->unsignedInteger('preparation_time')->comment('Minutes');
            $table->foreignId('subcategory_id')->constrained('subcategories')->restrictOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
