<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['workshop', 'cabang'])->default('cabang');
            $table->text('address');
            $table->decimal('lat', 10, 7);
            $table->decimal('lng', 10, 7);
            $table->decimal('radius_km', 5, 2)->default(3);
            $table->string('phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('open_hours')->nullable();
            $table->integer('sort_order')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
