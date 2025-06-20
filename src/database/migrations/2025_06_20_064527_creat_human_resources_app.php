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
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('roles', function (Blueprint $table) {    
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('address');
            $table->date('birth_date');
            $table->date('hire_date');
            $table->foreignId('department_id')->constrained('departments');
            $table->foreignId('role_id')->constrained('roles');
            $table->string('status');
            $table->decimal('salary', 10, 2);
            $table->timestamps();
            $table->softDeletes();
        });


        

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->foreignId('assigned_to')->constrained('employees');
            $table->string('status');
            $table->date('due_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('payroll', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->decimal('salary', 10, 2);
            $table->decimal('bonus', 10, 2)->nullable();
            $table->decimal('deduction', 10, 2)->nullable();
            $table->decimal('net_salary', 10, 2);
            $table->date('pay_date');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->date('date');
            $table->time('check_in');
            $table->time('check_out');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('leave_type');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('payroll');
        Schema::dropIfExists('presences');
        Schema::dropIfExists('leave_requests');
    }
};
