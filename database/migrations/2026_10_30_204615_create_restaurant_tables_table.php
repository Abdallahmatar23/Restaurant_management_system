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
        Schema::create('restaurant_tables', function (Blueprint $table) {
            $table->id();
            $table->string('table_number')->unique();
            $table->enum('type',['private','public']);
            $table->unsignedInteger('min_capacity');
            $table->unsignedInteger('max_capacity');
            $table->string('area')->nullable();
            // $table->enum('location',['ground floor','first floor','garden']);
            $table->enum('status',['available','occupied','reserved','maintenance'])->default('available');
            $table->text('notes')->nullable();
            $table->string('unique_token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
