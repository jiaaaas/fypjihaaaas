<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class QRCode extends Model
{
    use HasFactory, SoftDeletes;

    protected $keyType = 'uuid'; 
    public $incrementing = false; 
    protected $fillable = ['otp'];  // Add 'otp' here

    protected $table = 'qrcodes';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}

