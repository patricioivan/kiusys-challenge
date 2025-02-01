<?php
declare(strict_types=1);

namespace App\Models;

use DateTime;

class FlightEvent extends Flight {
    private DateTime $departureDatetime;
    private DateTime $arrivalDatetime;

    public function __construct(
        string $flightNumber,
        string $departureCity,
        string $arrivalCity,
        DateTime $departureDatetime,
        DateTime $arrivalDatetime
    ) {
        parent::__construct($flightNumber, $departureCity, $arrivalCity);
        $this->departureDatetime = $departureDatetime;
        $this->arrivalDatetime   = $arrivalDatetime;
    }

    public function getDepartureDatetime(): DateTime {
        return $this->departureDatetime;
    }

    public function getArrivalDatetime(): DateTime {
        return $this->arrivalDatetime;
    }

    public static function fromArray(array $data): self {
        return new self(
            $data['flight_number']  ?? '',
            $data['departure_city'] ?? '',
            $data['arrival_city']   ?? '',
            new DateTime($data['departure_datetime']),
            new DateTime($data['arrival_datetime'])
        );
    }

    public function toArray(): array {
        return [
            'flight_number'  => $this->getFlightNumber(),
            'from'           => $this->getDepartureCity(),
            'to'             => $this->getArrivalCity(),
            'departure_time' => $this->getDepartureDatetime()->format('Y-m-d H:i'),
            'arrival_time'   => $this->getArrivalDatetime()->format('Y-m-d H:i'),
        ];
    }
}
