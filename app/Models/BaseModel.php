<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model {

    public const QUIZ = 1;
    public const ASSIGNMENT = 2;
    public const PUBLISHED = 1;
    public const NO_PUBLISHED = 2;

    public static function booted() {
        static::addGlobalScope('is_deleted', function(Builder $builder) {
            $builder->where('is_deleted', 0);
        });
    }

}