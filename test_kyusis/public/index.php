<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

$urls = require_once __DIR__ . '/../config/urls.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];


if ($method === 'GET' && $uri === '/journeys/search') {
    $controller = new App\Controllers\JourneyController($urls['FLIGHT_EVENTS_API_URL']);
    $controller->index();
    exit;
}

http_response_code(404);
header('Content-Type: application/json');
echo json_encode(['error' => 'Endpoint not found']);
