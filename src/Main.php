<?php
/**
 * Vista principal de la Agenda de Contactos.
 * * Este archivo actúa como el panel de control central. Muestra el menú de
 * navegación y genera una tabla dinámica con todos los contactos
 * almacenados en la base de datos.
 * * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.0.0
 */

/** @var PDO $pdo Instancia de conexión a la BD */
require_once './models/Contacto.php';
require_once 'bd/config.php';

// Obtención de la lista de contactos para la tabla
$lista_contactos = Contacto::mostrarContactos($pdo);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <link rel="stylesheet" href="./styles.css">
</head>

<body>
<h1>Menú Principal</h1>
<nav>
    <ul>
        <li><a href="./view/form_new_contact.html">Añadir Contacto</a></li>
        <li><a href="./view/form_modify_contact.html">Modificar Contacto</a></li>
        <li><a href="./view/form_delete_contact.html">Eliminar Contacto</a></li>
        <li><a href="./limpiar_bd.php">Limpiar Contactos</a></li>
        <li><a href="./docs/">Documentación</a></li>
    </ul>
</nav>

<?php if ($lista_contactos): ?>
    <h2>Lista de Contactos</h2>
    <table style="width: 80%; border-collapse: collapse;">
        <thead>
        <tr style="background-color: #548a95ff;">
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Teléfono</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($lista_contactos as $contacto):
            /** * Sanitización de salida (Output Escaping)
             * Se usa htmlspecialchars para prevenir ataques XSS al mostrar datos de la BD.
             */
            $id = htmlspecialchars($contacto['id']);
            $name_html = htmlspecialchars($contacto['name']);
            $email_html = htmlspecialchars($contacto['email']);
            $phone_html = htmlspecialchars($contacto['phone']);
            ?>
            <tr style="background-color: #88cbc8ff;">
                <td><?php echo $id; ?></td>
                <td><?php echo $name_html; ?></td>
                <td><?php echo $email_html; ?></td>
                <td><?php echo $phone_html; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <h2>No se encontraron contactos</h2>
<?php endif; ?>
</body>
</html>