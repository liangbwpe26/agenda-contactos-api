<?php
/**
 * Configuración de la conexión a la base de datos.
 *
 * Este archivo establece los parámetros de conexión para la base de datos MySQL
 * utilizando la extensión PDO. Define la instancia global $pdo que será
 * utilizada por el resto de la aplicación.
 *
 * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.1.0
 */

// Parámetros de configuración del servidor
$host     = "db";
$nombreBD = "liang_bd";
$usuario  = "liang";
$pass     = "1234";

/**
 * @var PDO $pdo Instancia global de PDO para interactuar con la base de datos.
 */
$pdo = null;

try {
    /**
     * Creación de la instancia PDO con DSN (Data Source Name).
     * Se especifica charset=utf8 para evitar problemas con tildes y eñes.
     */
    $pdo = new PDO("mysql:host=$host;dbname=$nombreBD;charset=utf8", $usuario, $pass);

    /**
     * Configuración del modo de error.
     * ATTR_ERRMODE => ERRMODE_EXCEPTION: PDO lanzará excepciones que podemos
     * capturar en bloques try-catch en el resto de scripts.
     */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    /**
     * Gestión de errores de conexión.
     * En producción, es recomendable loguear el error y mostrar un mensaje genérico
     * para no exponer detalles de la infraestructura (como el host o usuario).
     */
    error_log("Fallo de conexión: " . $e->getMessage());
    die("Error crítico: No se pudo establecer la conexión con la base de datos.");
}