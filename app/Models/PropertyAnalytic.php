<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAnalytic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'analytic_type_id',
        'value',
    ];

    protected $casts = [
        'value' => 'float'
    ];

    /**
     * Get the Property for the Analytic.
     */
    public function property()
    {
        return $this->belongsTo('App\Models\Property');
    }

    /**
     * Scope a query to only PropertyAnalytics with a property from the passed country.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPropertyCountry($query, $country)
    {
        return $query->whereHas('property', function($q) use ($country){
            $q->where('country', $country);
        });
    }

    /**
     * Scope a query to only PropertyAnalytics with a property from the passed state.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPropertyState($query, $state)
    {
        return $query->whereHas('property', function($q) use ($state){
            $q->where('state', $state);
        });
    }

    /**
     * Scope a query to only PropertyAnalytics with a property from the passed suburb.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPropertySuburb($query, $suburb)
    {
        return $query->whereHas('property', function($q) use ($suburb){
            $q->where('suburb', $suburb);
        });
    }
}
