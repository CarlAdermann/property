<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country',
        'guid',
        'state',
        'suburb',
    ];

    /**
     * Get the Analytics for the Property.
     */
    public function analytics()
    {
        return $this->hasMany('App\Models\PropertyAnalytic');
    }
}
