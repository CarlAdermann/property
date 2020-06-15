<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'country' => 'required|max:30',
            'guid' => 'required|unique:properties|uuid',
            'state' => 'required|max:50',
            'suburb' => 'required|max:20',
        ]);

        try {
            $property = Property::create($request->only([
                'guid',
                'state',
                'suburb',
                'country',
            ]));

            logger('Property saved', [
                'id' => $property->id,
                'country' => $property->country,
                'state' => $property->state,
                'suburb' => $property->suburb,
                'guid' => $property->guid,
            ]);

            return $property;
        } catch (Exception $e) {
            logger()->error('Property save failed', [
                'message' => $e->getMessage(),
            ]);

            abort(500, 'Property save failed');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        //
    }
}
