<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeCharge extends Model
{
    use HasUuids;

    protected $table = 'employee_charge';

    protected $fillable = [
        'employee_id',
        'charge_id',
        'area',
        'start_date',
        'end_date',
        'active',
        'boss_id'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'active' => 'boolean',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function charge(): BelongsTo
    {
        return $this->belongsTo(Charge::class);
    }

    public function boss(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'boss_id');
    }
}
