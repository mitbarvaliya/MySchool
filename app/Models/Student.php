<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'name',
        'email',
        'phone',
        'password',
        'photo',   // ✅ Add this
    ];

    protected $hidden = [
        'password',
    ];

    /* ---------- Relationship ---------- */

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
