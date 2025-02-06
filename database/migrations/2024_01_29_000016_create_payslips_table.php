<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('payslip_number');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('basic_salary', 10, 2);
            $table->decimal('overtime_hours', 8, 2)->default(0);
            $table->decimal('overtime_rate', 10, 2)->default(0);
            $table->decimal('overtime_amount', 10, 2)->default(0);
            $table->decimal('performance_bonus', 10, 2)->default(0);
            $table->decimal('attendance_bonus', 10, 2)->default(0);
            $table->decimal('other_bonuses', 10, 2)->default(0);
            $table->text('bonus_description')->nullable();
            $table->decimal('allowances', 10, 2)->default(0);
            $table->decimal('deductions', 10, 2)->default(0);
            $table->decimal('net_salary', 10, 2);
            $table->date('issued_date');
            $table->enum('status', ['draft', 'issued', 'paid'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
