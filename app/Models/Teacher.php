<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo',   // ✅ Add this
    ];

    protected $hidden = [
        'password',
    ];

    /* ---------- Relationship ---------- */

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
