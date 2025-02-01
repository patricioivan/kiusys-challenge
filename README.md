# kiusys-challenge
1)

Iniciar el proyecto donde esta la API que trae TODOS los vuelos (test_kyusis_all_flights)
composer dump-autoload 
php -S localhost:8006 -t public


2)

Iniciar el proyecto de busqueda de vuelos (test_kyusis)
composer dump-autoload 
php -S localhost:8005 -t public

La razón de por que hice dos proyectos es para que no de error por ser monohilo
Asi el proyecto test_kiusys puede pegarle al endpoint de test_kiusys_all_flights para obtener el example de todos los vuelos, y no le tenga que pegarle internamente)
Otra alternativa que tenia era hacer un fixture en el mismo proyecto y obtener los datos, pero queria que sea lo mas "real" posible.


3)

Via postman o navegador pegarle a http://localhost:8005/journeys/search?date=2024-09-12&from=BUE&to=MAD

Te puede devolver esto

[ { "connections": 0, "path": [ { "flight_number": "XX1234", "from": "BUE", "to": "MAD", "departure_time": "2024-09-12 12:00", "arrival_time": "2024-09-13 00:00" } ] } ]

O esto en caso de que tenga conexiones

[ { "connections": 1, "path": [ { "flight_number": "XX1234", "from": "BUE", "to": "MAD", "departure_time": "2024-09-12 12:00", "arrival_time": "2024-09-13 00:00" }, { "flight_number": "XX2345", "from": "MAD", "to": "PMI", "departure_time": "2024-09-13 02:00", "arrival_time": "2024-09-13 03:00" } ] } ]
