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
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        Schema::create('itinerary', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->string('visibility')->default('public'); // Assuming visibility is a string, adjust as necessary
            $table->decimal('price', 8, 2)->default(0.0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('favourites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained('itinerary')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('query_string');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('stages', function (Blueprint $table){
            $table->id();
            $table->string('location');
            $table->
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
        Schema::dropIfExists('itinerary');
        Schema::dropIfExists('research');
        Schema::dropIfExists('favourites');
    }
};
