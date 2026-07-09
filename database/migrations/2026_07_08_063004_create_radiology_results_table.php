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
        Schema::create('radiology_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('radiology_request_id')->constrained()->onDelete('cascade');
            $table->text('findings')->nullable();
            $table->text('impression')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('notes')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamp('interpreted_at')->nullable();
            $table->foreignId('interpreted_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiology_results');
    }
};
