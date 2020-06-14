<?php

namespace App\Services;

use App\Models\PropertyAnalytic;
use App\Models\Property;

class Summary
{
    public function get($filters)
    {
        $properties =$this->getPropertyQuery($filters);
        $analytics = $this->getAnalyticsQuery($filters);

        $total = $properties->count();

        return [
            'min' => $analytics->min('value'),
            'max' => $analytics->max('value'),
            'median' => $analytics->average('value'),
            'with_value_percent' => $this->percent($properties->has('analytics')->count(), $total),
            'without_value_percent' => $this->percent($properties->doesntHave('analytics')->count(), $total),
        ];
    }

    private function getAnalyticsQuery($filters)
    {
        $query = PropertyAnalytic::query();

        if(!empty($filters['country'])) {
            $query->withPropertyCountry($filters['country']);
        }

        if(!empty($filters['state'])) {
            $query->withPropertyState($filters['state']);
        }

        if(!empty($filters['suburb'])) {
            $query->withPropertySuburb($filters['suburb']);
        }

        return $query;
    }

    private function getPropertyQuery($filters)
    {
        $propertyQuery = Property::query();

        if(!empty($filters['country'])) {
            $propertyQuery->whereCountry($filters['country']);
        }

        if(!empty($filters['state'])) {
            $propertyQuery->whereState($filters['state']);

        }

        if(!empty($filters['suburb'])) {
            $propertyQuery->whereSuburb($filters['suburb']);
        }

        return $propertyQuery;
    }

    private function percent($count, $total)
    {
        if ($count === 0) {
            return 0;
        }

        return $count / $total * 100;
    }
}
