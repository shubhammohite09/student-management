<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'invoice_number',
        'title',
        'amount',
        'paid_amount',
        'due_date',
        'payment_status',
        'payment_method',
        'paid_at',
        'notes',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'amount' => 'float',
        'paid_amount' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
