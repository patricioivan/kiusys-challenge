# kiusys-challenge
Iniciar el proyecto donde esta la API que trae TODOS los vuelos composer dump-autoload php -S localhost:8006 -t public

Iniciar el proyecto de busqueda de vuelos composer dump-autoload php -S localhost:8005 -t public

Via postman o navegador pegarle a http://localhost:8005/journeys/search?date=2024-09-12&from=BUE&to=MAD

Te puede devolver esto

[ { "connections": 0, "path": [ { "flight_number": "XX1234", "from": "BUE", "to": "MAD", "departure_time": "2024-09-12 12:00", "arrival_time": "2024-09-13 00:00" } ] } ]

O esto en caso de que tenga conexiones

[ { "connections": 1, "path": [ { "flight_number": "XX1234", "from": "BUE", "to": "MAD", "departure_time": "2024-09-12 12:00", "arrival_time": "2024-09-13 00:00" }, { "flight_number": "XX2345", "from": "MAD", "to": "PMI", "departure_time": "2024-09-13 02:00", "arrival_time": "2024-09-13 03:00" } ] } ]
