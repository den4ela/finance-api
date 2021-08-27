<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'employee_id',
        'amount',
        'details'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'details' => 'array'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function employee()
    {
        return $this->hasOne(User::class, 'employee_id', 'id');
    }
}
