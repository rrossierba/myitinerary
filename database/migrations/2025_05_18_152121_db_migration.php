<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('region');
            $table->string('state');
            $table->timestamps();

            $table->unique(['name', 'region', 'state']);
        });

        Schema::create('itinerary', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
            $table->string('visibility')->default('public'); // Assuming visibility is a string, adjust as necessary
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('favourites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('itinerary_id')->constrained('itinerary')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['itinerary_id', 'user_id']);
        });

        Schema::create('research', function (Blueprint $table) {
            $table->id();
            $table->string('query_string');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('stages', function (Blueprint $table){
            $table->id();
            $table->string('location')->nullable(true);
            $table->string('description')->nullable(true);
            $table->integer('duration')->nullable(true)->default(0);
            $table->decimal('cost', 8, 2)->default(0.0);
            $table->foreignId('itinerary_id')->constrained('itinerary')->onDelete('cascade');
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
        Schema::dropIfExists('stages');
    }
};
