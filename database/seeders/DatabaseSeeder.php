<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\FeeInvoice;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 1. Admin User
        User::firstOrCreate(
            ['email' => 'admin@sms.edu'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Departments
        $cs = Department::create([
            'name' => 'Computer Science & Engineering',
            'code' => 'CS',
            'description' => 'Focuses on computing theory, algorithms, software engineering, and artificial intelligence.',
            'head_of_department' => 'Dr. Robert Vance',
            'email' => 'cs-dept@sms.edu',
            'phone' => '+1 (555) 234-5678',
        ]);

        $it = Department::create([
            'name' => 'Information Technology',
            'code' => 'IT',
            'description' => 'Applied computer science, network infrastructure, cybersecurity, and cloud operations.',
            'head_of_department' => 'Prof. Sarah Jenkins',
            'email' => 'it-dept@sms.edu',
            'phone' => '+1 (555) 345-6789',
        ]);

        $bba = Department::create([
            'name' => 'Business Administration',
            'code' => 'BBA',
            'description' => 'Modern management, finance, marketing, and business analytics.',
            'head_of_department' => 'Dr. Michael Sterling',
            'email' => 'bba-dept@sms.edu',
            'phone' => '+1 (555) 456-7890',
        ]);

        $ee = Department::create([
            'name' => 'Electrical & Electronics',
            'code' => 'EE',
            'description' => 'Circuits, embedded systems, robotics, and power engineering.',
            'head_of_department' => 'Dr. Angela Miller',
            'email' => 'ee-dept@sms.edu',
            'phone' => '+1 (555) 567-8901',
        ]);

        // 3. Courses
        $c1 = Course::create([
            'department_id' => $cs->id,
            'course_code' => 'CS301',
            'course_name' => 'Database Management Systems',
            'credits' => 4,
            'semester' => 6,
            'instructor_name' => 'Dr. Robert Vance',
            'capacity' => 45,
            'description' => 'Relational database architecture, SQL queries, indexing, and transaction management.',
        ]);

        $c2 = Course::create([
            'department_id' => $cs->id,
            'course_code' => 'CS302',
            'course_name' => 'Web Architecture & PHP Laravel',
            'credits' => 4,
            'semester' => 6,
            'instructor_name' => 'Prof. Alex Turner',
            'capacity' => 40,
            'description' => 'MVC architecture, RESTful API design, Eloquent ORM, Blade templating, and security.',
        ]);

        $c3 = Course::create([
            'department_id' => $cs->id,
            'course_code' => 'CS303',
            'course_name' => 'Data Structures & Algorithms',
            'credits' => 4,
            'semester' => 4,
            'instructor_name' => 'Dr. Emily Chen',
            'capacity' => 50,
            'description' => 'Algorithmic complexity, tree and graph traversals, and dynamic programming.',
        ]);

        $c4 = Course::create([
            'department_id' => $cs->id,
            'course_code' => 'CS304',
            'course_name' => 'Operating Systems & Concurrency',
            'credits' => 3,
            'semester' => 5,
            'instructor_name' => 'Dr. Robert Vance',
            'capacity' => 45,
            'description' => 'Processes, threads, synchronization primitives, virtual memory, and file systems.',
        ]);

        $c5 = Course::create([
            'department_id' => $it->id,
            'course_code' => 'IT201',
            'course_name' => 'Cloud Infrastructure & DevOps',
            'credits' => 3,
            'semester' => 5,
            'instructor_name' => 'Prof. Sarah Jenkins',
            'capacity' => 35,
            'description' => 'CI/CD pipelines, containerization with Docker, Kubernetes, and AWS deployment.',
        ]);

        $c6 = Course::create([
            'department_id' => $bba->id,
            'course_code' => 'BBA101',
            'course_name' => 'Financial Accounting & Reporting',
            'credits' => 3,
            'semester' => 2,
            'instructor_name' => 'Dr. Michael Sterling',
            'capacity' => 60,
            'description' => 'Balance sheets, cash flow analysis, corporate finance, and auditing fundamentals.',
        ]);

        $courses = [$c1, $c2, $c3, $c4, $c5, $c6];

        // 4. Students
        $studentsData = [
            [
                'admission_number' => 'STU230103',
                'department_id' => $cs->id,
                'first_name' => 'Chloe',
                'last_name' => 'Davis',
                'email' => 'chloe.davis@email.com',
                'phone' => '+1 555-123-4567',
                'gender' => 'Female',
                'date_of_birth' => '2004-04-15',
                'address' => '742 Evergreen Terrace',
                'city' => 'Springfield',
                'guardian_name' => 'Mark Davis',
                'guardian_phone' => '+1 555-987-6543',
                'enrollment_date' => '2023-09-01',
                'current_semester' => 6,
                'status' => 'Active',
            ],
            [
                'admission_number' => 'STU230101',
                'department_id' => $cs->id,
                'first_name' => 'Alice',
                'last_name' => 'Green',
                'email' => 'alice.green@email.com',
                'phone' => '+1 555-234-5671',
                'gender' => 'Female',
                'date_of_birth' => '2004-02-18',
                'address' => '12 Maple Avenue',
                'city' => 'Boston',
                'guardian_name' => 'Helen Green',
                'guardian_phone' => '+1 555-876-5432',
                'enrollment_date' => '2023-09-01',
                'current_semester' => 6,
                'status' => 'Active',
            ],
            [
                'admission_number' => 'STU230102',
                'department_id' => $it->id,
                'first_name' => 'Ben',
                'last_name' => 'Carter',
                'email' => 'ben.carter@email.com',
                'phone' => '+1 555-345-6782',
                'gender' => 'Male',
                'date_of_birth' => '2003-11-20',
                'address' => '88 Oak Lane',
                'city' => 'Austin',
                'guardian_name' => 'James Carter',
                'guardian_phone' => '+1 555-765-4321',
                'enrollment_date' => '2023-09-01',
                'current_semester' => 5,
                'status' => 'Active',
            ],
            [
                'admission_number' => 'STU230104',
                'department_id' => $bba->id,
                'first_name' => 'David',
                'last_name' => 'Lee',
                'email' => 'david.lee@email.com',
                'phone' => '+1 555-456-7893',
                'gender' => 'Male',
                'date_of_birth' => '2004-08-30',
                'address' => '45 Pine Boulevard',
                'city' => 'Seattle',
                'guardian_name' => 'Richard Lee',
                'guardian_phone' => '+1 555-654-3210',
                'enrollment_date' => '2024-01-15',
                'current_semester' => 3,
                'status' => 'Active',
            ],
            [
                'admission_number' => 'STU230105',
                'department_id' => $cs->id,
                'first_name' => 'Elena',
                'last_name' => 'Rostova',
                'email' => 'elena.rostova@email.com',
                'phone' => '+1 555-567-8904',
                'gender' => 'Female',
                'date_of_birth' => '2003-06-12',
                'address' => '102 Sunset Way',
                'city' => 'San Jose',
                'guardian_name' => 'Dmitri Rostov',
                'guardian_phone' => '+1 555-543-2109',
                'enrollment_date' => '2023-09-01',
                'current_semester' => 6,
                'status' => 'Active',
            ],
            [
                'admission_number' => 'STU230106',
                'department_id' => $ee->id,
                'first_name' => 'Lucas',
                'last_name' => 'Silva',
                'email' => 'lucas.silva@email.com',
                'phone' => '+1 555-678-9015',
                'gender' => 'Male',
                'date_of_birth' => '2004-10-05',
                'address' => '309 Beacon Street',
                'city' => 'Denver',
                'guardian_name' => 'Carlos Silva',
                'guardian_phone' => '+1 555-432-1098',
                'enrollment_date' => '2023-09-01',
                'current_semester' => 4,
                'status' => 'Active',
            ],
            [
                'admission_number' => 'STU230107',
                'department_id' => $it->id,
                'first_name' => 'Sophia',
                'last_name' => 'Martinez',
                'email' => 'sophia.martinez@email.com',
                'phone' => '+1 555-789-0126',
                'gender' => 'Female',
                'date_of_birth' => '2004-03-22',
                'address' => '514 Hillcrest Drive',
                'city' => 'Chicago',
                'guardian_name' => 'Maria Martinez',
                'guardian_phone' => '+1 555-321-0987',
                'enrollment_date' => '2023-09-01',
                'current_semester' => 5,
                'status' => 'Active',
            ],
            [
                'admission_number' => 'STU230108',
                'department_id' => $cs->id,
                'first_name' => 'Marcus',
                'last_name' => 'Johnson',
                'email' => 'marcus.johnson@email.com',
                'phone' => '+1 555-890-1237',
                'gender' => 'Male',
                'date_of_birth' => '2003-12-04',
                'address' => '210 University Ave',
                'city' => 'Atlanta',
                'guardian_name' => 'Anthony Johnson',
                'guardian_phone' => '+1 555-210-9876',
                'enrollment_date' => '2023-09-01',
                'current_semester' => 6,
                'status' => 'Inactive',
            ]
        ];

        $createdStudents = [];
        foreach ($studentsData as $data) {
            $createdStudents[] = Student::create($data);
        }

        // Enroll students into courses
        foreach ($createdStudents as $student) {
            // Enroll in first 3 courses
            for ($i = 0; $i < 3; $i++) {
                Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $courses[$i]->id,
                    'academic_year' => '2026-2027',
                    'semester' => 'Semester ' . $student->current_semester,
                    'enrollment_date' => $student->enrollment_date,
                    'status' => 'Enrolled',
                ]);
            }
        }

        // Attendance records for past 7 days
        $today = Carbon::today();
        foreach ($createdStudents as $idx => $student) {
            for ($d = 6; $d >= 0; $d--) {
                $date = $today->copy()->subDays($d);
                if ($date->isWeekend()) continue;

                // Most students are present; Ben Carter is occasionally late/absent
                $status = 'Present';
                if ($student->first_name === 'Ben' && $d === 1) {
                    $status = 'Absent';
                } elseif ($student->first_name === 'Marcus') {
                    $status = ($d % 2 === 0) ? 'Absent' : 'Present';
                }

                Attendance::create([
                    'student_id' => $student->id,
                    'course_id' => $c1->id,
                    'date' => $date->toDateString(),
                    'status' => $status,
                    'remarks' => $status === 'Absent' ? 'Medical leave requested' : 'Regular on-time',
                ]);
            }
        }

        // Specific Grades for Chloe Davis matching the Canva mockup
        $chloe = $createdStudents[0];
        Grade::create([
            'student_id' => $chloe->id,
            'course_id' => $c1->id,
            'exam_type' => 'Final Examination',
            'marks_obtained' => 94.00,
            'total_marks' => 100.00,
            'grade_letter' => 'A',
            'grade_point' => 4.00,
            'remarks' => 'Exceptional schema design and query execution performance',
        ]);

        Grade::create([
            'student_id' => $chloe->id,
            'course_id' => $c2->id,
            'exam_type' => 'Final Examination',
            'marks_obtained' => 97.50,
            'total_marks' => 100.00,
            'grade_letter' => 'A+',
            'grade_point' => 4.00,
            'remarks' => 'High mastery of Laravel MVC structure, Blade, and Eloquent models',
        ]);

        Grade::create([
            'student_id' => $chloe->id,
            'course_id' => $c3->id,
            'exam_type' => 'Midterm Examination',
            'marks_obtained' => 88.00,
            'total_marks' => 100.00,
            'grade_letter' => 'A-',
            'grade_point' => 3.70,
            'remarks' => 'Proficient with graph algorithms and dynamic programming',
        ]);

        Grade::create([
            'student_id' => $chloe->id,
            'course_id' => $c4->id,
            'exam_type' => 'Assignment Portfolio',
            'marks_obtained' => 91.00,
            'total_marks' => 100.00,
            'grade_letter' => 'A',
            'grade_point' => 4.00,
            'remarks' => 'Clean multi-threaded process simulation implementation',
        ]);

        // Grades for Alice Green
        $alice = $createdStudents[1];
        Grade::create([
            'student_id' => $alice->id,
            'course_id' => $c1->id,
            'exam_type' => 'Final Examination',
            'marks_obtained' => 89.00,
            'total_marks' => 100.00,
            'grade_letter' => 'A-',
            'grade_point' => 3.70,
            'remarks' => 'Very good database indexing and normalization understanding',
        ]);

        // Fee Invoices matching Canva mockup
        // Chloe Davis
        FeeInvoice::create([
            'student_id' => $chloe->id,
            'invoice_number' => 'INV-2026-001',
            'title' => 'Semester 6 Tuition & Lab Fee',
            'amount' => 2450.00,
            'paid_amount' => 2450.00,
            'due_date' => Carbon::now()->subDays(15),
            'payment_status' => 'Paid',
            'payment_method' => 'Bank Transfer',
            'paid_at' => Carbon::now()->subDays(18),
            'notes' => 'Full payment received through Wire Transfer #TXN99281',
        ]);

        FeeInvoice::create([
            'student_id' => $chloe->id,
            'invoice_number' => 'INV-2026-002',
            'title' => 'Annual Campus Library & Tech Resource Fee',
            'amount' => 350.00,
            'paid_amount' => 350.00,
            'due_date' => Carbon::now()->subDays(45),
            'payment_status' => 'Paid',
            'payment_method' => 'Credit Card',
            'paid_at' => Carbon::now()->subDays(48),
            'notes' => 'Payment processed online via portal',
        ]);

        // Alice Green
        FeeInvoice::create([
            'student_id' => $alice->id,
            'invoice_number' => 'INV-2026-003',
            'title' => 'Semester 6 Tuition Fee',
            'amount' => 2450.00,
            'paid_amount' => 2450.00,
            'due_date' => Carbon::now()->subDays(10),
            'payment_status' => 'Paid',
            'payment_method' => 'Online Portal',
            'paid_at' => Carbon::now()->subDays(12),
            'notes' => 'Paid in full',
        ]);

        // Ben Carter
        FeeInvoice::create([
            'student_id' => $createdStudents[2]->id,
            'invoice_number' => 'INV-2026-004',
            'title' => 'Semester 5 Tuition Fee',
            'amount' => 2450.00,
            'paid_amount' => 1200.00,
            'due_date' => Carbon::now()->addDays(10),
            'payment_status' => 'Partial',
            'payment_method' => 'Cash',
            'paid_at' => Carbon::now()->subDays(5),
            'notes' => 'First installment received. Second installment of $1,250 due next week.',
        ]);

        // David Lee
        FeeInvoice::create([
            'student_id' => $createdStudents[3]->id,
            'invoice_number' => 'INV-2026-005',
            'title' => 'Semester 3 Tuition Fee',
            'amount' => 2200.00,
            'paid_amount' => 0.00,
            'due_date' => Carbon::now()->addDays(14),
            'payment_status' => 'Unpaid',
            'payment_method' => null,
            'paid_at' => null,
            'notes' => 'Invoice sent to student email',
        ]);
    }
}
