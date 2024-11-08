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
