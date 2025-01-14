<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusWork extends Model
{
    use HasFactory;

protected $fillable = ['name']; 

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }

}

