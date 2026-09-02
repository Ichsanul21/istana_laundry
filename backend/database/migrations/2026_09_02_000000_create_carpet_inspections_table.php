<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carpet_inspections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('whatsapp', 20);
            $table->text('notes')->nullable();
            $table->string('photo_path');
            $table->string('token', 32)->unique();
            $table->string('status')->default('processing'); // processing | completed | failed
            $table->string('overall_condition')->nullable();
            $table->unsignedTinyInteger('cleanliness_score')->nullable();
            $table->json('findings')->nullable();
            $table->text('recommendation')->nullable();
            $table->text('summary')->nullable();
            $table->longText('raw_response')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carpet_inspections');
    }
};
