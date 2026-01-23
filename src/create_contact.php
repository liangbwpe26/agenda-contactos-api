<?php
/**
 * Script de creación de contactos.
 * * Este archivo procesa las peticiones POST para validar e insertar
 * nuevos contactos en la base de datos. Realiza validaciones de
 * formato de email y teléfono antes de la inserción.
 * * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.0.0
 */

require_once 'bd/config.php';
require_once 'funciones.php';
require_once 'models/Contacto.php';

$proceder_insercion = true;
$errores = [];

/** @var PDO $pdo Conexión a la base de datos definida en config.php */

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Verificación de existencia de campos
    if (isset($_POST['name'], $_POST['email'], $_POST['phone'])) {

        // 2. Saneamiento de datos
        $name  = filtrarDatos($_POST['name']);
        $email_raw = $_POST['email'];
        $phone = filtrarDatos($_POST['phone']);
        $email = null;

        // 3. Validaciones específicas
        if (validarEmail($email_raw)) {
            $email = filtrarEmail($email_raw);
        } else {
            $errores[] = "El email no es válido.";
            $proceder_insercion = false;
        }

        if (!validarTelefono($phone)) {
            $errores[] = "El teléfono no es válido.";
            $proceder_insercion = false;
        }

        // 4. Inserción si todo es correcto
        if ($proceder_insercion) {
            // Llamamos al método estático de la clase Contacto
            $contacto = new Contacto($name, $email, $phone);
            $contacto->insertarContacto($pdo);
            echo "<h2>✅ Contacto añadido correctamente</h2>";
        } else {
            // Mostrar errores de validación
            foreach ($errores as $error) {
                echo "<p style='color:red;'>⚠️ $error</p>";
            }
        }

    } else {
        echo "<h1>⚠️ Completa todos los campos</h1>";
    }

    echo "<br><a href='Main.php'>Volver al formulario</a>";
}