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
        Schema::create('inpatient_admissions', function (Blueprint $table) {
            $table->id();
            $table->string('admission_number')->unique();
            $table->foreignId('registration_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('doctor_id')->constrained();
            $table->date('admission_date');
            $table->time('admission_time');
            $table->date('discharge_date')->nullable();
            $table->time('discharge_time')->nullable();
            $table->enum('status', ['active', 'discharged', 'transferred', 'deceased'])->default('active');
            $table->text('primary_diagnosis')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inpatient_admissions');
    }
};
