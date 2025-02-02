<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\JourneySearchService;
use DateTime;

class JourneyController {
    private JourneySearchService $journeySearchService;

    public function __construct(string $flightEventsApiUrl) {
        $this->journeySearchService = new JourneySearchService($flightEventsApiUrl);
    }

    public function index(): void {
        header('Content-Type: application/json');

        // Aca voy a hacer todas las validaciones que creo necesarias, sera mi "seccion" de validaciones
        // la voy a hacer aca porque considero que es un sistema sencillo pero podria hacer como en laravel
        // cque cuando hago un request a un controlador, esta el formrequest que se encarga de las validaciones y queda mas limpio.

        if (!isset($_GET['date'], $_GET['from'], $_GET['to'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Necesito que especifiques la fecha, el origen y el destino, de lo contraio no puedo hacer la busqueda']);
            return;
        }

        $date = $_GET['date'];
        $from = strtoupper($_GET['from']);
        $to   = strtoupper($_GET['to']);

        $dateObj = DateTime::createFromFormat('Y-m-d', $date);
        if (!$dateObj || $dateObj->format('Y-m-d') !== $date) {
            http_response_code(400);
            echo json_encode(['error' => 'Formato de fecha invalido. Se espera el formato YYYY-MM-DD (AÑO-MES-DIA) Por ejemplo : 2025-02-01']);
            return;
        }

        // Aca termina mi seccion de validaciones y recien ahora hago el request al servicio

        try {
            $journeys = $this->journeySearchService->searchJourneys($date, $from, $to);
            echo json_encode($journeys);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
