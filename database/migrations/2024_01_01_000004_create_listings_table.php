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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['product', 'service'])->default('product');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('country_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('state_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('area_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->decimal('price', 12, 2);
            $table->string('currency', 5)->default('INR');
            $table->enum('status', ['active', 'sold', 'expired'])->default('active');
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['category_id', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
