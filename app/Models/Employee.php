<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employee';

    // use HasFactory;

    protected $fillable = ['name', 'phone_no', 'email', 'address', 'status_work_id', 'department_id', 'password'];

    public function statusWork()
    {
        return $this->belongsTo(StatusWork::class, 'status_work_id'); // Assuming foreign key is status_work_id
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    
    public function scopeFilter($query, $filters){
        $query->when($filters['name'] ?? false, function($query, $filter){
            $query->where('name', 'like', "%$filter%");
        });

        $query->when($filters['phone_no'] ?? false, function($query, $filter){
            $query->where('phone_no', 'like', "%$filter%");
        });

        $query->when($filters['email'] ?? false, function($query, $filter){
            $query->where('email', 'like', "%$filter%");
        });     
           
        $query->when($filters['address'] ?? false, function($query, $filter){
            $query->where('address', 'like', "%$filter%");
        });                
        $query->when($filters['status_work_id'] ?? false, function($query, $filter) {
            $query->whereHas('statusWork', function($query) use ($filter) {
                $query->where('name', $filter);
            });
        });

    }

    // public function attendances()
    // {
    //     return $this->hasMany(Attendance::class);
    // }



}
