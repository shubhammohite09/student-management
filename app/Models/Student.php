<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_number',
        'department_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'city',
        'guardian_name',
        'guardian_phone',
        'enrollment_date',
        'current_semester',
        'status',
        'avatar',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
        'current_semester' => 'integer',
    ];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
                    ->withPivot(['academic_year', 'semester', 'status', 'enrollment_date'])
                    ->withTimestamps();
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function feeInvoices()
    {
        return $this->hasMany(FeeInvoice::class);
    }

    public function getAttendanceRateAttribute()
    {
        $total = $this->attendances()->count();
        if ($total === 0) {
            return 100;
        }
        $present = $this->attendances()->whereIn('status', ['Present', 'Late'])->count();
        return round(($present / $total) * 100, 1);
    }

    public function getGpaAttribute()
    {
        $grades = $this->grades;
        if ($grades->isEmpty()) {
            return 3.50;
        }
        return round($grades->avg('grade_point'), 2);
    }
}
