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
        Schema::create('routes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Kigali City Route"
            $table->foreignId('bus_id')->constrained('buses')->onDelete('cascade');
            $table->json('pickup_points');  // e.g., ["Kimironko","Remera"]
            $table->json('dropoff_points'); // e.g., ["IRERERO Academy"]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes');
    }
};
