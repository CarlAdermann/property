<?php

namespace App\Http\Controllers;

use App\Models\PropertyAnalytic;
use Illuminate\Http\Request;
use Exception;

class PropertyAnalyticController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($propertyId)
    {
        return PropertyAnalytic::wherePropertyId($propertyId)->get();
    }

    /**
     * Store a newly created PropertyAnalytic resource in storage.
     *
     * @param  Integer  $propertyId
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($propertyId, Request $request)
    {
        $request->validate([
            'analytic_type_id' => 'required|exists:App\Models\AnalyticType,id',
            'value' => 'required|numeric',
        ]);

        try {
            $propertyAnalytic = PropertyAnalytic::create([
                'property_id' => $propertyId,
                'analytic_type_id' => $request->input('analytic_type_id'),
                'value' => $request->input('value'),
            ]);

            logger('Property Analytic saved', [
                'property_analytic_id' => $propertyAnalytic->id
            ]);

            return $propertyAnalytic;

        } catch (Exception $e) {
            logger()->error('Property Analytic save failed', [
                'property_id' => $propertyId,
                'property_analytic_id' => $request->input('analytic_type_id'),
                'message' => $e->getMessage(),
            ]);

            abort(500, 'Property Analytic save failed');
        }
    }

    /**
     * Display the specified PropertyAnalytic resource.
     *
     * @param  \App\Models\PropertyAnalytic  $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyAnalytic $propertyAnalytic)
    {
        return $propertyAnalytic;
    }

    /**
     * Update the specified PropertyAnalytic resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PropertyAnalytic  $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PropertyAnalytic $analytic)
    {
        $request->validate([
            'property_id' => 'exists:App\Models\Property,id',
            'analytic_type_id' => ' exists:App\Models\AnalyticType,id',
            'value' => 'numeric',
        ]);

        try {
            $analytic->update($request->only([
                'property_id',
                'analytic_type_id',
                'value'
            ]));
        } catch (Exception $e) {
            logger()->error('Property Analytic update failed', [
                'property_analytic_id' => $analytic->id,
                'message' => $e->getMessage()
            ]);

            abort(500, 'Property Analytic update failed');
        }

        logger('Property Analytic updated', [
            'property_analytic_id' => $analytic->id,
        ]);

        return $analytic;
    }

    /**
     * Remove the specified PropertyAnalytic resource from storage.
     *
     * @param  \App\Models\PropertyAnalytic  $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyAnalytic $analytic)
    {
        if($analytic->delete()){
            logger('Property Analytic deleted', [
                'property_analytic_id' => $analytic->id,
            ]);
        } else {
            logger()->error('Property Analytic delete failed', [
                'property_analytic_id' => $analytic->id,
            ]);

            abort(500, 'Property Analytic delete failed');
        }
    }
}
