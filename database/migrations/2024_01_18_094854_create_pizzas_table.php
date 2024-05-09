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
        Schema::create('pizzas', function (Blueprint $table) {
            $table->id();
            $table->string('pizza_name');
            $table->string('pizza_desc');
            $table->decimal('pizza_small_price', 8, 2);
            $table->decimal('pizza_medium_price', 8, 2);
            $table->decimal('pizza_large_price', 8, 2);
            $table->unsignedBigInteger('pizza_category'); // Foreign key reference
            $table->string('pizza_image');
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('pizza_category')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzas');
    }
};

