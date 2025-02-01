<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\FlightEvent;
use Exception;

class FlightEventsService {
    private string $apiUrl;

    public function __construct(string $apiUrl) {
        $this->apiUrl = $apiUrl;
    }

    public function getFlightEvents(): array {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $this->apiUrl);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            if ($response === false) {
                $error = curl_error($curl);
                curl_close($curl);
                throw new Exception($error);
            }
            curl_close($curl);

            $data = json_decode($response, true);

            //Aca dicho sea de paso lo simplifco, por cuestiones de tiempo pero si fuera una respuesta MUY grande deberia paginarla
            // y si fueran +1.000.000 de registros haria un chunk + cursor pagination

            $events = [];
            foreach ($data as $eventData) {
                $events[] = FlightEvent::fromArray($eventData);
            }
            return $events;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
