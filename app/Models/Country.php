<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'country';

    protected $fillable = [
        'name',
        'code',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class, 'country_id');
    }
}
