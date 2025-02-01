<?php
declare(strict_types=1);

namespace App\Models;

class Flight {
    protected string $flightNumber;
    protected string $departureCity;
    protected string $arrivalCity;

    public function __construct(string $flightNumber, string $departureCity, string $arrivalCity) {
        $this->flightNumber  = $flightNumber;
        $this->departureCity = strtoupper($departureCity);
        $this->arrivalCity   = strtoupper($arrivalCity);
    }

    public function getFlightNumber(): string {
        return $this->flightNumber;
    }

    public function getDepartureCity(): string {
        return $this->departureCity;
    }

    public function getArrivalCity(): string {
        return $this->arrivalCity;
    }
}
