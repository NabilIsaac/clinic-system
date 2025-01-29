<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreignId('test_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('diagnosis_id')->constrained()->onDelete('cascade');
            $table->string('test_number')->unique();
            $table->datetime('test_datetime');
            $table->text('results')->nullable();
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // pending, completed, cancelled
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tests');
    }
};
