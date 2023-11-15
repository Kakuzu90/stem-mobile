<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueWithDelete implements Rule
{
    public $table;
    public $column;
    public $id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $table, string $column, int $id = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->id = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->where('is_deleted', 0);
        if ($this->id) {
            $query->where('id', '!=', $this->id);
        }
        return $query->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute has already been taken.';
    }
}
