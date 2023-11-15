<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('is_deleted', function(Builder $builder) {
            $builder->where('is_deleted', 0);
        });
    }

    protected $fillable = [
        'name', 'username', 'password',
        'is_deleted'
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];

    public function setNameAttribute($value) {
        return $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value) {
        return $this->attributes['name'] = ucwords($value);
    }

    public function setPasswordAttribute($value) {
        return $this->attributes['password'] = Hash::make($value);
    }
}
