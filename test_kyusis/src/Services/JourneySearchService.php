<?php
declare(strict_types=1);

namespace App\Services;

use App\Actions\SearchJourneyAction;
use App\Services\FlightEventsService;

class JourneySearchService {
    private FlightEventsService $flightEventsService;
    private SearchJourneyAction $searchJourneyAction;

    public function __construct(string $flightEventsApiUrl) {
        $this->flightEventsService = new FlightEventsService($flightEventsApiUrl);
        $this->searchJourneyAction = new SearchJourneyAction();
    }

    public function searchJourneys(string $date, string $from, string $to): array {
        $flightEvents = $this->flightEventsService->getFlightEvents(); 
        return $this->searchJourneyAction->execute($flightEvents, $date, $from, $to);
    }
}
