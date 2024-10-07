<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'credits',
        'class',
        'lecturerId',
    ];

    public function Lecturer(){
        return $this->belongsTo(Lecturer::class);
    }
}
