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
        Schema::create('checkups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
            $table->string('bp')->nullable();
            // $table->dateTime('walk-in_datetime')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->string('reason')->nullable();
            // $table->json('symptoms')->nullable();
            $table->text('visit_history')->nullable();
            $table->text('additional_comments')->nullable();
            // $table->dateTime('date');
            $table->enum('status', ['pending', 'in-progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkups');
    }
};
