<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Services\Delivery\DeliveryService;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deliveries = Delivery::all();
        return $deliveries;
    }

    /*
     *  POST /deliveries
     *
        [
            {
                "sourceKladr": "7700000000000",
                "targetKladr": "3701200004700",
                "weight":"12.7",
                "pickedTransportCompanyId": "2"
            },
            {
                "sourceKladr": "7700000000000",
                "targetKladr": "1801400000000",
                "weight":"5",
                "pickedTransportCompanyId": ""
            },
            {
                "sourceKladr": "7700000000000",
                "targetKladr": "5005100000000",
                "weight":"2",
                "pickedTransportCompanyId": "4"
            }
        ]
     * */
    public function calculate(Request $request)
    {
        $deliverService = new DeliveryService();
        $deliverService->setData($request->all());

        $results = $deliverService->calculate();
        return response()->json($results);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Delivery $delivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Delivery $delivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delivery $delivery)
    {
        //
    }
}
