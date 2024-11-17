TRABAJO PRACTICO N 3

INTEGRANTES:

Echaide Iñaki
Velez Matias

Endpoints disponibles:

TURNOS:

{{base_url}}=http://localhost/3-prueba/web2-entrega3/api

- obtener token  (BASIC AUTH webadmin admin)
GET {{base_url}}/usuarios/token

/usuarios/token 

- Lista todos los turnos
GET {{base_url}}/turnos 

- Obtiene un turno específico
GET {{base_url}}/turnos/55 

- Filtrar y ordenar combinado
GET {{base_url}}/turnos?id_cliente=44&orderBy=fecha_turno&orderDirection=DESC&page=1&limit=3

- Paginar
GET {{base_url}}/turnos?page=1&limit=2

- Crea un nuevo turno 
POST {{base_url}}/turnos 
Authorization: (Bearer token: jwt obtenido)

body ejemplo

{
    "id_cliente": 44,
    "fecha_turno": "2024-03-01",
    "hora_turno": "10:00:00",
    "finalizado": 0
}

- Actualiza un turno
PUT {{base_url}}/turnos/70  
Authorization: (Bearer token: jwt obtenido)

body ejemplo

{
	 "id_cliente": 44,
    "fecha_turno": "2024-03-01",
    "hora_turno": "10:00:00",
    "finalizado": 0
}


- Elimina un turno
DELETE {{base_url}}/turnos/70 
Authorization: (Bearer token: jwt obtenido)


CLIENTES: 

- Lista todos los clientes
GET {{base_url}}/clientes 

- Obtiene un clientes específico
GET {{base_url}}/clientes/55 

- Filtrar y ordenar combinado
GET {{base_url}}/clientes?nombre=juan&orderBy=id_cliente&orderDirection=DESC&page=1&limit=2

- Paginar
GET {{base_url}}/clientes?page=1&limit=2

- Crea un nuevo clientes 
POST {{base_url}}/clientes 
Authorization: (Bearer token: jwt obtenido)

body ejemplo

{
    "nombre": juan,
    "telefono": "2495478982",
    "email": "juan@juan.com",
    "foto": NULL
}

- Actualiza un cliente
PUT {{base_url}}/clientes/70  
Authorization: (Bearer token: jwt obtenido)

body ejemplo

{
	"nombre": "juancito",
    	"telefono": "2495478982",
    	"email": "juan@juan.com",
    	"foto": NULL
}


- Elimina un clientes
DELETE {{base_url}}/clientes/70 
Authorization: (Bearer token: jwt obtenido)
