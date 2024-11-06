TRABAJO PRACTICO N 3

INTEGRANTES:

Echaide Iñaki
Velez Matias

Endpoints disponibles:

TURNOS:

obtener token  (BASIC AUTH webadmin admin)
GET http://localhost/3-prueba/web2-entrega3/api/usuarios/token 

Lista todos los turnos
GET http://localhost/3-prueba/web2-entrega3/api/turnos 

Obtiene un turno específico
GET http://localhost/3-prueba/web2-entrega3/api/turnos/55 

Filtrar y ordenar combinado
GET http://localhost/3-prueba/web2-entrega3/api/turnos?id_cliente=44&orderBy=fecha_turno&orderDirection=DESC&page=1&limit=3

Paginar
GET http://localhost/3-prueba/web2-entrega3/api/turnos?page=1&limit=2

Crea un nuevo turno 
POST http://localhost/3-prueba/web2-entrega3/api/turnos 
Authorization: (Bearer token: jwt obtenido)

body ejemplo

{
    "id_cliente": 44,
    "fecha_turno": "2024-03-01",
    "hora_turno": "10:00:00",
    "finalizado": 0
}

Actualiza un turno
PUT http://localhost/3-prueba/web2-entrega3/api/turnos/70  
Authorization: (Bearer token: jwt obtenido)

body ejemplo

{
	 "id_cliente": 44,
    "fecha_turno": "2024-03-01",
    "hora_turno": "10:00:00",
    "finalizado": 0
}


Elimina un turno
DELETE http://localhost/3-prueba/web2-entrega3/api/turnos/70 
Authorization: (Bearer token: jwt obtenido)
