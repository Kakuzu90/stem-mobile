<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class Student extends Authenticatable
{
    use HasFactory;

    protected static function booted()
    {
        static::addGlobalScope('is_deleted', function(Builder $builder) {
            $builder->where('is_deleted', 0);
        });
    }

    protected $fillable = [
        'first_name', 'middle_name', 'last_name',
        'age', 'address', 'username',
        'password', 'date_valid', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'password', 'date_valid'
    ];

    protected $dates = [
        'date_valid'
    ];

    public function subject() {
        return $this->hasMany(StudentSubject::class);
    }

    public function subjects() {
        return $this->hasMany(StudentSubject::class)->select('subject_id')->groupBy('subject_id');
    }

    public function classrooms() {
        return $this->hasMany(StudentSubject::class)->select('classroom_id')->groupBy('classroom_id');
    }

    public function getProfileAttribute() {
        return asset('images/student.png');
    }

    public function setFirstNameAttribute($value) {
        return $this->attributes['first_name'] = strtolower($value);
    }

    public function setMiddleNameAttribute($value) {
        return $this->attributes['middle_name'] = strtolower($value);
    }

    public function setLastNameAttribute($value) {
        return $this->attributes['last_name'] = strtolower($value);
    }

    public function setPasswordAttribute($value) {
        return $this->attributes['password'] = Hash::make($value);
    }

    public function getFirstNameAttribute($value) {
        return $this->attributes['first_name'] = ucwords($value);
    }

    public function getMiddleNameAttribute($value) {
        return $this->attributes['middle_name'] = ucwords($value);
    }

    public function getLastNameAttribute($value) {
        return $this->attributes['last_name'] = ucwords($value);
    }

    public function getFullNameAttribute() {
        return $this->first_name . ' ' . $this->middle_name[0] . '. ' . $this->last_name;
    }

    public function scopeHasDuplicate($query, $request) {
        return $query->where([
            'first_name' => $request['first_name'], 
            'middle_name' => $request['middle_name'], 
            'last_name' => $request['last_name']])->exists();
    }

    public function scopeExpired($query) {
        return $query->whereDate('date_valid', '<', Carbon::now())->count();
    }

    public function scopeActive($query) {
        return $query->whereDate('date_valid', '>=', Carbon::now())->count();
    }

    public function isExpired() {
        return Carbon::now()->gt($this->date_valid) ? 'text-danger' : null;
    }
}
