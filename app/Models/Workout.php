<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'exercise_id',
        'repetitions',
        'weight',
        'break_time',
        'day',
        'observations',
        'time'
    ];

    public function students(){
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function exercises(){
        return $this->belongsTo(Exercise::class, 'exercise_id', 'id');
    }
}
