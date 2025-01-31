<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('blood_type')->nullable();
            $table->text('allergies')->nullable();
            $table->text('chronic_diseases')->nullable();
            $table->decimal('bmi', 4, 2)->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone')->nullable();
            $table->string('emergency_contact_relation')->nullable();
            $table->string('insurance_company')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('policy_number')->nullable();
            $table->string('issued_date')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('member_number')->nullable();
            $table->string('primary_care_physician')->nullable();
            $table->string('physician_phone')->nullable();
            $table->longText('medical_history')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
