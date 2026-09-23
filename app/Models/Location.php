<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'type', 'parent_id'];

    /**
     * Get the parent location.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_id');
    }

    /**
     * Get child locations.
     */
    public function children(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_id')->orderBy('name');
    }

    /**
     * Scope to get only countries.
     */
    public function scopeCountries($query)
    {
        return $query->where('type', 'country')->orderBy('name');
    }

    /**
     * Scope to get only states.
     */
    public function scopeStates($query)
    {
        return $query->where('type', 'state')->orderBy('name');
    }

    /**
     * Scope to get only cities.
     */
    public function scopeCities($query)
    {
        return $query->where('type', 'city')->orderBy('name');
    }

    /**
     * Scope to get only areas.
     */
    public function scopeAreas($query)
    {
        return $query->where('type', 'area')->orderBy('name');
    }
}
