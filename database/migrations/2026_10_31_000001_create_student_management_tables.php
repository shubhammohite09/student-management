<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('head_of_department')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->timestamps();
        });

        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('admission_number')->unique();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->default('Male');
            $table->date('date_of_birth');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->date('enrollment_date');
            $table->integer('current_semester')->default(1);
            $table->enum('status', ['Active', 'Inactive', 'Graduated', 'Suspended'])->default('Active');
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->string('course_code')->unique();
            $table->string('course_name');
            $table->integer('credits')->default(3);
            $table->integer('semester')->default(1);
            $table->string('instructor_name')->nullable();
            $table->integer('capacity')->default(40);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('academic_year')->default('2026-2027');
            $table->string('semester')->default('Semester 1');
            $table->date('enrollment_date');
            $table->enum('status', ['Enrolled', 'Completed', 'Dropped'])->default('Enrolled');
            $table->timestamps();
            $table->unique(['student_id', 'course_id', 'academic_year', 'semester']);
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['Present', 'Absent', 'Late', 'Excused'])->default('Present');
            $table->string('remarks')->nullable();
            $table->timestamps();
            $table->unique(['student_id', 'course_id', 'date']);
        });

        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();
            $table->string('exam_type')->default('Final Exam');
            $table->decimal('marks_obtained', 5, 2);
            $table->decimal('total_marks', 5, 2)->default(100.00);
            $table->string('grade_letter', 5)->default('A');
            $table->decimal('grade_point', 3, 2)->default(4.00);
            $table->string('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('fee_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('title');
            $table->decimal('amount', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0.00);
            $table->date('due_date');
            $table->enum('payment_status', ['Paid', 'Partial', 'Unpaid'])->default('Unpaid');
            $table->string('payment_method')->nullable();
            $table->dateTime('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fee_invoices');
        Schema::dropIfExists('grades');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('enrollments');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('students');
        Schema::dropIfExists('departments');
    }
};
