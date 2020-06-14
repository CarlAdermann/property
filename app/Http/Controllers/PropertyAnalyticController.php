<?php

namespace App\Http\Controllers;

use App\Models\PropertyAnalytic;
use Illuminate\Http\Request;

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
     * Store a newly created resource in storage.
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

        return PropertyAnalytic::create([
            'property_id' => $propertyId,
            'analytic_type_id' => $request->input('analytic_type_id'),
            'value' => $request->input('value'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PropertyAnalytic  $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function show(PropertyAnalytic $propertyAnalytic)
    {
        return $propertyAnalytic;
    }

    /**
     * Update the specified resource in storage.
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

        $analytic->update($request->only([
            'property_id',
            'analytic_type_id',
            'value'
        ]));

        return $analytic;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PropertyAnalytic  $propertyAnalytic
     * @return \Illuminate\Http\Response
     */
    public function destroy(PropertyAnalytic $analytic)
    {
        return $analytic->delete();
    }
}
