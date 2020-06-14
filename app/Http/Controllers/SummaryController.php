<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PropertyAnalytic;
use App\Models\Property;
use App\Services\Summary;


class SummaryController extends Controller
{
    private $summary;

    public function __construct(Summary $summary)
    {
        $this->summary = $summary;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->validate([
            'country' => 'alpha',
            'state' => 'alpha',
            'suburb' => 'alpha',
        ]);

        $summary = $this->summary->get($request->only([
            'country',
            'state',
            'suburb',
        ]));

        return response()->json($summary);
    }
}
