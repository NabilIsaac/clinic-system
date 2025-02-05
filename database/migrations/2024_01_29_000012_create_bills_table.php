<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('checkup_id')->nullable()->constrained()->onDelete('set null');
            $table->string('bill_number')->unique();
            $table->date('bill_date');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->string('status')->default('unpaid'); // unpaid, partially_paid, paid
            $table->date('due_date');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            // $table->string('bill_type');
            // $table->string('bill_number')->unique();
            // $table->date('period_start');
            // $table->date('period_end');
            // $table->date('due_date');
            // $table->decimal('amount', 10, 2);
            // $table->text('notes')->nullable();
            // $table->string('status')->default('pending');
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
