<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'city';

    protected $fillable = [
        'name',
        'country_id',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'birthplace_id');
    }
}
