📑 Proyecto: Agenda de Contactos
Breve descripción del proyecto. Por ejemplo: "Una aplicación de consola/escritorio diseñada para
gestionar una lista de contactos personales, permitiendo realizar operaciones CRUD básicas."

✨ Características
Agregar contactos: Guarda nombre, teléfono, correo y dirección.

Buscar: Localiza contactos rápidamente por nombre o apellido.

Editar: Actualiza la información de contactos existentes.

Eliminar: Borra registros de forma permanente.

✨ Métodos API REST
En este proyecto, utilizamos los verbos HTTP estándar para gestionar el ciclo de vida de los contactos:

GET (Consultar): Se utiliza para obtener información del servidor.

Ejemplo: GET /api/contactos.php devuelve la lista de todos los contactos.


POST (Crear): Se utiliza para enviar datos nuevos al servidor con el fin de crear un registro.

Ejemplo: POST /api/contactos.php enviando un JSON con el nombre y teléfono del nuevo contacto.

PUT (Actualizar): Se utiliza para reemplazar o editar un contacto existente de forma integral. Requiere que envíes todos los datos del objeto para actualizarlos en la base de datos.

Ejemplo: PUT /api/contactos.php/?id=5 actualiza toda la información del contacto con ID 5.