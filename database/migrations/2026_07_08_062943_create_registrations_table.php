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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('polyclinic_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('insurance_id')->nullable()->constrained()->onDelete('set null');
            $table->string('registration_number')->unique();
            $table->enum('type', ['rawat_jalan', 'igd', 'rawat_inap']);
            $table->enum('status', ['waiting', 'in_triage', 'in_examination', 'in_treatment', 'completed', 'cancelled'])->default('waiting');
            $table->text('complaint')->nullable()->comment('Keluhan utama');
            $table->string('referral_from')->nullable();
            $table->foreignId('registered_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('registration_time');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
