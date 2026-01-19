# Proyecto: Agenda de Contactos
Breve descripción del proyecto: 
"Una aplicación diseñada para gestionar una lista de contactos personales mediante una API REST, permitiendo realizar operaciones CRUD básicas de forma eficiente."

# Características
El sistema permite gestionar la información esencial de cada usuario con las siguientes funciones:Agregar contactos: Guarda nombre, teléfono, correo y dirección.Buscar: Localiza contactos rápidamente por nombre o apellido.Editar: Actualiza la información de contactos existentes.

# Métodos API REST
Utilizamos los verbos HTTP estándar para gestionar el ciclo de vida de los contactos. A continuación, se detalla la estructura de las peticiones:
MétodoAcciónDescripción
Ejemplo de Endpoint
# GET
Consultar
Obtiene la lista de contactos o uno específico.
GET /api/contactos.phpPOSTCrearEnvía datos nuevos para crear un registro.POST /api/contactos.php
# PUT
Actualizar
Reemplaza o edita un contacto existente (integral).
PUT /api/contactos.php?id=5
# DELETE
Eliminar
Remueve un contacto de la base de datos.DELETE /api/contactos.php?id=5
Ejemplos de uso:
Petición POST (Crear):
Se debe enviar un cuerpo en formato JSON con la estructura del contacto:

JSON
{

"nombre": "Juan Perez",
"telefono": "123456789",
"correo": "juan@example.com"

}

Petición PUT (Actualizar):
Requiere enviar todos los campos del objeto para sobrescribir el registro identificado por el ID en la URL.
# Requisitos previos
Antes de instalar y ejecutar el proyecto, asegúrate de tener:
PHP >= 8.0
MySQL / MariaDB (Base de datos relacional)
Servidor Web (Recomendado: Caddy o Apache)
Git instalado para el control de versiones