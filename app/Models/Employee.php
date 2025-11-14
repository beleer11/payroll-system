<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'employee';

    protected $fillable = [
        'name',
        'lastname',
        'identification',
        'address',
        'phone',
        'birthplace_id',
        'country_id',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function birthplace(): BelongsTo
    {
        return $this->belongsTo(City::class, 'birthplace_id');
    }

    public function boss(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'boss_id');
    }

    public function collaborators(): HasMany
    {
        return $this->hasMany(Employee::class, 'boss_id');
    }

    public function charges(): BelongsToMany
    {
        return $this->belongsToMany(Charge::class, 'employee_charge')
            ->withPivot('area', 'start_date', 'end_date', 'active', 'boss_id')
            ->withTimestamps();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->name} {$this->lastname}";
    }

    public function activeCharge(): ?Charge
    {
        return $this->charges()->wherePivot('active', true)->first();
    }

    public function currentCharge()
    {
        return $this->charges()->wherePivot('active', true)->first();
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
