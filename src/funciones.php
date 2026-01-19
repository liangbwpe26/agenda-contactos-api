<?php
/**
 * Utilidades de validación y saneamiento de datos.
 *
 * Este archivo contiene funciones auxiliares para la limpieza de entradas
 * del usuario y la validación de formatos específicos como emails y teléfonos.
 *
 * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.0.0
 */

/**
 * Limpia y sanea una cadena de texto.
 * * Elimina espacios en blanco innecesarios, barras invertidas y convierte
 * caracteres especiales en entidades HTML para prevenir ataques XSS.
 *
 * @param string $dato La cadena de texto original.
 * @return string La cadena saneada.
 */
function filtrarDatos($dato) {
    return htmlspecialchars(stripslashes(trim($dato)));
}

/**
 * Valida si una dirección de correo electrónico tiene un formato correcto.
 *
 * @param string $email El correo electrónico a validar.
 * @return bool True si el formato es válido, false en caso contrario.
 */
function validarEmail($email) {
    $validacion = false;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $validacion = true;
    }
    return $validacion;
}

/**
 * Sanea una dirección de correo electrónico.
 * * Elimina todos los caracteres excepto letras, dígitos y $-_.+!*'(),{}|\\^~[]`<>#%";/?:@&=.
 *
 * @param string $email El correo electrónico original.
 * @return string El correo electrónico saneado.
 */
function filtrarEmail($email) {
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

/**
 * Valida si un número de teléfono tiene una longitud exacta de 9 caracteres.
 *
 * @param string $phone El número de teléfono a validar.
 * @return bool True si tiene 9 caracteres, false en caso contrario.
 */
function validarTelefono($phone) {
    $validacion = false;
    if (strlen($phone) == 9) {
        $validacion = true;
    }
    return $validacion;
}


/**
 * Devuelve una respuesta formateada en json y el código HTTP correspondiente
 */
function formatearRespuesta($datos, int $codigo)
{
    http_response_code($codigo);
    //no escapar unicode
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
}

function obtenerDatosPeticion()
{
    //lee la petición completa HTTP, el body enviado por el cliente en json
    $cuerpo = file_get_contents("php://input");
    //convierte json a array
    return json_decode($cuerpo, true) ?? [];
}