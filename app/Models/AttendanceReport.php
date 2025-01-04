<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class AttendanceReport extends Model
{
    protected $table = 'attendance_report';

    protected $fillable = [
        'id', 'employee_id', 'report_type', 'year', 'month', 'total_days', 'on_time_days', 'performance'
    ];

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
