<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Charge extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'charge';

    protected $fillable = [
        'name',
        'description',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(Employee::class, 'employee_charge', 'charge_id', 'employee_id')
            ->withPivot('start_date', 'end_date', 'active')
            ->withTimestamps();
    }
}
