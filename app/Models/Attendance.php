<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Attendance extends Model
{

    use SoftDeletes; 

    
    protected $fillable = ['employee_id', 'scanned', 'status'];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopeFilter($query, $filters)
    {
        // Filter by employee name
        $query->when($filters['name'] ?? false, function($query, $filter) {
            $query->whereHas('employee', function($query) use ($filter) {
                $query->where('name', 'like', '%'.$filter.'%');
            });
        });

        // Filter by employee department
        $query->when($filters['department'] ?? false, function($query, $filter) {
            $query->whereHas('employee.department', function($query) use ($filter) {
                $query->where('name', 'like', '%'.$filter.'%'); // Assuming the `departments` table has a `name` field
            });
        });
    }
}
