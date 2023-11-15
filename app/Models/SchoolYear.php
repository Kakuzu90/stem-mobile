<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

class SchoolYear extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'name', 'date_from',
        'date_to', 'is_deleted'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date'
    ];

    public function classrooms() {
        return $this->hasMany(Classroom::class);
    }

    public function scopeHasConflict($query, $date_from, $date_to) {
        return $query->where(function ($query) use ($date_from, $date_to) {
            $query->whereBetween('date_from', [$date_from, $date_to])
                ->orWhereBetween('date_to', [$date_from, $date_to])
                ->orWhere(function ($query) use ($date_from, $date_to) {
                    $query->where('date_from', '<=', $date_from)
                        ->where('date_to', '>=', $date_to);
                });
        })->exists();
    }

    public function isActive() {
        $date_from = Carbon::parse($this->date_from);
        $date_to = Carbon::parse($this->date_to);
        return Carbon::now()->between($date_from, $date_to);
    }

    public function status() {
        if ($this->isActive()) {
            return 'Active';
        }
        return 'Inactive';
    }

    public function status_color() {
        if ($this->isActive()) {
            return 'success';
        }
        return 'danger';
    }
}
