<?php
/**
 * Script de modificación de contactos.
 * * Este archivo procesa las peticiones POST para actualizar la información
 * de un contacto existente. Crea una instancia de la clase Contacto y
 * ejecuta la actualización basada en el ID proporcionado.
 * * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.0.1
 */

require_once 'bd/config.php';
require_once 'funciones.php';
require_once 'models/Contacto.php';

/** * @var PDO $pdo Instancia de conexión a la base de datos definida en config.php
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // 1. Verificación de integridad de los datos recibidos
    if (isset($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['id'])) {

        // 2. Saneamiento de las entradas del usuario
        $id = filtrarDatos($_POST['id']);
        $name = filtrarDatos($_POST['name']);
        $email = filtrarDatos($_POST['email']);
        $phone = filtrarDatos($_POST['phone']);

        /**
         * 3. Lógica de Modificación.
         * Se instancia el objeto con los datos actuales para persistirlos en la BD.
         */
        $contacto = new Contacto($id, $name, $email, $phone);

        // 4. Intento de actualización y feedback al usuario
        if ($contacto->modificarContacto($pdo)) {
            echo "<h1>✅ Contacto Modificado correctamente</h1>";
        } else {
            // Este caso ocurre si el ID no existe o si los datos enviados son idénticos a los actuales
            echo "<h1>⚠️ No se pudo modificar el contacto (ID no encontrado o sin cambios)</h1>";
        }

        echo "<a href='Main.php'>Volver al menú principal</a>";

    } else {
        echo "<h1>❌ Error: Completa todos los campos requeridos</h1>";
    }
}