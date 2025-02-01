<?php
declare(strict_types=1);

namespace App\Controllers;

class FlightEventsController {
    public function index(): void {
        header('Content-Type: application/json');
        $sampleResponse = [
            [
                "flight_number" => "XX1234",
                "departure_city" => "BUE",
                "arrival_city" => "MAD",
                "departure_datetime" => "2024-09-12T12:00:00.000Z",
                "arrival_datetime" => "2024-09-13T00:00:00.000Z"
            ],
            [
                "flight_number" => "XX2345",
                "departure_city" => "MAD",
                "arrival_city" => "PMI",
                "departure_datetime" => "2024-09-13T02:00:00.000Z",
                "arrival_datetime" => "2024-09-13T03:00:00.000Z"
            ]
        ];
        echo json_encode($sampleResponse);
    }
}
