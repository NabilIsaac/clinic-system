<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('employee_type_id')->constrained();
            $table->foreignId('department_id')->constrained();
            $table->string('phone');
            $table->string('address');
            $table->date('joining_date');
            $table->decimal('salary', 10, 2);
            $table->string('bank_account')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('qualifications')->nullable();
            $table->text('specialization')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
