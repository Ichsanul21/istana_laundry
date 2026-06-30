<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('location_checks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('whatsapp');
            $table->text('address');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->foreignId('nearest_branch_id')->nullable()->constrained('branches')->nullOnDelete();
            $table->decimal('distance_km', 8, 3)->nullable();
            $table->boolean('is_within_radius')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('location_checks');
    }
};
