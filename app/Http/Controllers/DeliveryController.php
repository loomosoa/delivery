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
                "pickedTransportCompanyId": "1"
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
    #########
    Response
    #########
        [
            {
                "sourceKladr": "7700000000000",
                "targetKladr": "3701200004700",
                "weight": 12.7,
                "companies": {
                    "SDEK": {
                        "fastDelivery": {
                            "price": 546,
                            "date": "2023-10-12",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 225,
                            "date": "2023-10-16",
                            "error": ""
                        },
                        "isCompanyPicked": true
                    },
                    "Express": {
                        "fastDelivery": {
                            "price": 970,
                            "date": "2023-10-12",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 315,
                            "date": "2023-10-16",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "Boxberry": {
                        "fastDelivery": {
                            "price": 490,
                            "date": "2023-10-15",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 255,
                            "date": "2023-10-11",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "DHL": {
                        "fastDelivery": {
                            "price": 435,
                            "date": "2023-10-12",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 540,
                            "date": "2023-10-19",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    }
                }
            },
            {
                "sourceKladr": "7700000000000",
                "targetKladr": "1801400000000",
                "weight": 5,
                "companies": {
                    "SDEK": {
                        "fastDelivery": {
                            "price": 620,
                            "date": "2023-10-18",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 225,
                            "date": "2023-10-15",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "Express": {
                        "fastDelivery": {
                            "price": 958,
                            "date": "2023-10-15",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 315,
                            "date": "2023-10-15",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "Boxberry": {
                        "fastDelivery": {
                            "price": 573,
                            "date": "2023-10-16",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 255,
                            "date": "2023-10-17",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "DHL": {
                        "fastDelivery": {
                            "price": 820,
                            "date": "2023-10-16",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 540,
                            "date": "2023-10-14",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    }
                }
            },
            {
                "sourceKladr": "7700000000000",
                "targetKladr": "5005100000000",
                "weight": 2,
                "companies": {
                    "SDEK": {
                        "fastDelivery": {
                            "price": 975,
                            "date": "2023-10-17",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 225,
                            "date": "2023-10-11",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "Express": {
                        "fastDelivery": {
                            "price": 600,
                            "date": "2023-10-13",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 315,
                            "date": "2023-10-17",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "Boxberry": {
                        "fastDelivery": {
                            "price": 466,
                            "date": "2023-10-15",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 255,
                            "date": "2023-10-17",
                            "error": ""
                        },
                        "isCompanyPicked": false
                    },
                    "DHL": {
                        "fastDelivery": {
                            "price": 567,
                            "date": "2023-10-17",
                            "error": ""
                        },
                        "slowDelivery": {
                            "price": 540,
                            "date": "2023-10-19",
                            "error": ""
                        },
                        "isCompanyPicked": true
                    }
                }
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
