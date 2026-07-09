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
        Schema::create('emergency_visits', function (Blueprint $table) {
            $table->id();
            $table->string('emergency_number')->unique();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('doctor_id')->nullable()->constrained();
            $table->enum('triage', ['resuscitation', 'emergency', 'urgent', 'semi_urgent', 'non_urgent'])->nullable();
            $table->enum('status', ['in_triage', 'in_treatment', 'observation', 'admitted', 'discharged', 'referred', 'deceased'])->default('in_triage');
            $table->text('complaint')->nullable();
            $table->text('diagnosis')->nullable();
            $table->text('treatment')->nullable();
            $table->text('disposition')->nullable()->comment('Rujuk/pulang/rawat_inap');
            $table->timestamp('arrival_time');
            $table->timestamp('discharge_time')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_visits');
    }
};
