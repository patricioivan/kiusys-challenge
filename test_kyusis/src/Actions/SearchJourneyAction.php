<?php
declare(strict_types=1);

namespace App\Actions;

use App\Enums\JourneyType;
use App\Models\FlightEvent;

class SearchJourneyAction {
    /**
     * @param FlightEvent[] $flightEvents
     * @param string $date 
     * @param string $from 
     * @param string $to 
     * @return array[]
     */
    public function execute(array $flightEvents, string $date, string $origin, string $destination): array {
        $journeys = [];
                
        $originFlights = array_filter($flightEvents, function (FlightEvent $originFlight) use ($date, $origin) {
            return $originFlight->getDepartureDatetime()->format('Y-m-d') === $date &&
                   $originFlight->getDepartureCity() === $origin;
        });
        
        foreach ($originFlights as $originFlight) {
            $departureTimestamp = $originFlight->getDepartureDatetime()->getTimestamp();
            $arrivalTimestamp = $originFlight->getArrivalDatetime()->getTimestamp();
            $durationHours = ($arrivalTimestamp - $departureTimestamp) / 3600;
            
            if ($originFlight->getArrivalCity() === $destination && $durationHours <= 24) {
                $journeys[] = [
                    'connections' => JourneyType::DIRECT->value,
                    'path' => [$originFlight->toArray()]
                ];
            }
            
            $connectionFlights = array_filter($flightEvents, function (FlightEvent $secondFlight) use ($originFlight, $destination) {
                if ($secondFlight->getDepartureCity() !== $originFlight->getArrivalCity() ||
                    $secondFlight->getArrivalCity() !== $destination ||
                    $secondFlight->getDepartureDatetime() <= $originFlight->getArrivalDatetime()
                ) {
                    return false;
                }
                
                $connectionTimeHours = ($secondFlight->getDepartureDatetime()->getTimestamp() - $originFlight->getArrivalDatetime()->getTimestamp()) / 3600;
                $totalDurationHours = ($secondFlight->getArrivalDatetime()->getTimestamp() - $originFlight->getDepartureDatetime()->getTimestamp()) / 3600;
                
                return $connectionTimeHours <= 4 && $totalDurationHours <= 24;
            });

            foreach ($connectionFlights as $secondFlight) {
                $journeys[] = [
                    'connections' => JourneyType::CONNECTING->value,
                    'path' => [
                        $originFlight->toArray(),      
                        $secondFlight->toArray()
                    ]
                ];
            }
        }
        return $journeys;
    }
}
