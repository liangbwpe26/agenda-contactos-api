<?php
/**
 * Script para el vaciado completo de la tabla de contactos.
 * * Este archivo ejecuta una sentencia SQL TRUNCATE para eliminar todos los
 * registros de la tabla 'contactos' y reiniciar los contadores de ID autoincrementales.
 * * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.0.0
 */

require_once 'bd/config.php';

/** * @var PDO $pdo Instancia de conexión a la base de datos. */

try {
    // Configuramos PDO para que lance excepciones en caso de error
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    /**
     * Sentencia SQL TRUNCATE.
     * A diferencia de DELETE, TRUNCATE es más rápido y reinicia el contador AUTO_INCREMENT.
     */
    $sql = "TRUNCATE TABLE contactos;";
    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    echo "<h1>✅ Todos los contactos han sido borrados y la tabla reiniciada</h1>";
    echo "<a href='Main.php'>Volver al menú principal</a>";

} catch (PDOException $e) {
    // Registro del error en el log del servidor y mensaje al usuario
    error_log("Error en TRUNCATE: " . $e->getMessage());
    echo "<h1>❌ Error al vaciar la tabla: " . $e->getMessage() . "</h1>";
} finally {
    // Liberación del recurso de la sentencia
    $stmt = null;
}