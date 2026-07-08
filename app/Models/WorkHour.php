<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkHour extends Model
{
    protected $fillable = ['start_time', 'end_time', 'late_tolerance'];
}
