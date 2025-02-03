# kiusys-challenge

PASOS PARA INICIAR EN LOCAL
1)

Iniciar el proyecto donde esta la API que trae TODOS los vuelos (test_kyusis_all_flights)

a) composer dump-autoload 
b) php -S localhost:8006 -t public


2)

Iniciar el proyecto de busqueda de vuelos (test_kyusis)


a) composer dump-autoload 
n) php -S localhost:8005 -t public

La razón de por que hice dos proyectos es para que no de error por ser monohilo
Asi el proyecto test_kiusys puede pegarle al endpoint de test_kiusys_all_flights para obtener el example de todos los vuelos, y no le tenga que pegarle internamente)
Otra alternativa que tenia era hacer un fixture en el mismo proyecto y obtener los datos, pero queria que sea lo mas "real" posible.


3)

Via postman o navegador pegarle, por ejemplo, a http://localhost:8005/journeys/search?date=2024-09-12&from=BUE&to=MAD

Te puede devolver esto

[ { "connections": 0, "path": [ { "flight_number": "XX1234", "from": "BUE", "to": "MAD", "departure_time": "2024-09-12 12:00", "arrival_time": "2024-09-13 00:00" } ] } ]

O esto en caso de que tenga conexiones

[ { "connections": 1, "path": [ { "flight_number": "XX1234", "from": "BUE", "to": "MAD", "departure_time": "2024-09-12 12:00", "arrival_time": "2024-09-13 00:00" }, { "flight_number": "XX2345", "from": "MAD", "to": "PMI", "departure_time": "2024-09-13 02:00", "arrival_time": "2024-09-13 03:00" } ] } ]

En todo caso, jugar agregando mas datos al proyecto de test kiusys all flight.


EXPLICACION DE LA ESTRUCTURA DEL PROYECTO de kiusys 

[public/index.php] <-- punto de partida donde hago un ruteo simple, apuntando al controller "Journeycontroller"

[src] <-- todos los arhcivos relacionados al codigo en si

[Controllers] <-- Controladores en donde manejo la logica de validaciones (si el proyecto ufera mas grande haria formsrequest) y donde llamo a un servicio correspondiente al controller
En este caso mi unico controlador es la clase journeycontroller, que se encarga de validar que exista date, from y to en los parametros.
Luego, una vez pasads las validaciones llamo al servicio JourneySearchService.

[Services] <-- Clases donde tengo logica de negocios y comunicacion con apis de terceros (en este caso mi misma api del otr proyecto)
En este caso, el primer servicio al que accedo es journeysearchservice gracias a la llamada desde el controller. Este sericio lo que hace es primeramente llamar a OTRO servicio (fligheventservice)
cuya tarea, es hacer una solicitud a la otra api que hice para obtener todos los vuelos disponibles, y desde el modelo, convierto en array la respuesta (podria haber usado un dto) y devuelvo todos los flightevents.
Luego de obtenidos losflightevents el journeysearchservice ejecuta la action searchjourneyaction.

[Actions] <-- Todo el codigo relacionado a logica especifica, o una funcionalidad atomica.
En este caso, tengo solo la action searchjourneyaction, que se encarga de basicamente buscar coincidencias entre lo que me devolvio la api de todos los vuelos, con lo solicitado del usuario, todo a medida de los requerimientos del test. Tiene una sola responsabilidad est aaction, y me gusta hacerlas porque son faciles de testear.

[Enums] <-- una carpeta que me gusta tener, para almacenar constantes y separar bien la logica. Por ejemplo tengo journeytipe como unico enum en el codigo, que en este caso, la llamo en la action para especificar si tiene connections o no.
Es decir, en mi enum tengo la constante DIRECT <- significa que el vuelo es directo por lo tanto el valor es 0 (o sea, DIRECTO -> 0 VUELOS), y por otr lado el valor CONNECTING <- sgnifica que el vuelo tiene una conexion (le puse el valor 1) Todo esto para que la key "connections" devuelva si tiene 0 o 1 conexiones.

[Models] <-- En este caso son las entidade que me solicito la prueba, si bien se podia hacer el ejercicio sin modelos, creo que estaba claro que era mejor forma de organizar.
En este caso, tengo dos modelos.
"Flight" que es una entidad padre, con valores "flightnumberr" "departurecity" y "arrivalcity" porque todos los vuelos, ya sea un evento de vuelo o no, tienen esas propiedades.
Luego, hice otra clase que hereda de flightm, por lo que ya tengo esas propiedades disponbiles en el hijo mas las especificas de un flightevent.
Decidi hacerla con dos clases y herencia porque el enunciado decia esto " [La diferencia entre vuelo y evento de vuelo es que un vuelo se repite con una frecuencia
determinada a lo largo del tiempo, mientras que un evento de vuelo, representa una
“instancia de ese vuelo en una fecha especifica”] " y me parecio clave la palabra "instancia" para decidir hacer herencia.

[config] <-- guardo url en este caso. Las guardo directamente hardcodeadas porque no queria instalar ningun paquete en el proyecto, pero si no usaria un .env y desde el config llamaria al valor de la variable en el .env
		



