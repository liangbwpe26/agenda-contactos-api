<?php
/**
 * Script de eliminación de contactos.
 * * Este archivo procesa las peticiones POST para eliminar de forma permanente
 * un registro de la base de datos utilizando su identificador único (ID).
 * * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.0.1
 */

require_once 'bd/config.php';
require_once 'funciones.php';
require_once 'models/Contacto.php';

/** * @var PDO $pdo Instancia de conexión a la base de datos.
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    /**
     * Verificación de la presencia del ID.
     * Se requiere el ID del contacto para ejecutar la sentencia DELETE.
     */
    if (isset($_POST['id'])) {

        // Saneamiento del ID recibido
        $id = filtrarDatos($_POST['id']);

        /**
         * Ejecución de la eliminación.
         * Se llama al método estático de la clase Contacto.
         */
        if (Contacto::eliminarContacto($pdo, $id)) {
            echo "<h1>✅ Contacto eliminado correctamente</h1>";
        } else {
            // Este bloque se ejecuta si el ID no existe o hubo un fallo en la consulta
            echo "<h1>⚠️ Error: El contacto no existe o no pudo ser eliminado</h1>";
        }

        echo "<a href='Main.php'>Volver al inicio</a>";

    } else {
        echo "<h1>❌ Error: ID de contacto no proporcionado</h1>";
        echo "<a href='Main.php'>Volver al inicio</a>";
    }
}