<?php
header("Content-Type: application/json; charset=utf-8");

require_once "bd/config.php";
require_once "models/Contacto.php";
require_once "funciones.php";

$metodo = $_SERVER["REQUEST_METHOD"];

$id = $_GET['id'] ?? null;

/** @var PDO $pdo Conexión definida en config.php */

switch ($metodo) {
    case 'GET':
    {
        if ($id) {
            $contacto = Contacto::obtenerContactoPorId($pdo, $id);
            if (!$contacto) {
                formatearRespuesta(["error" => "Contacto no encontrado"], 404);
            } else {
                formatearRespuesta($contacto, 200);
            }
        } else {
            $lista = Contacto::mostrarContactos($pdo);
            formatearRespuesta($lista, 200);
        }
        break;
    }

    case 'POST':
    {
        $contactoInformado = obtenerDatosPeticion();
        if (empty($contactoInformado["name"]) || empty($contactoInformado["phone"]) || empty($contactoInformado["email"])) {
            formatearRespuesta(["error" => "No se han informado los datos del contacto correctamente"], 400);
        } else {
            $contacto = new Contacto($contactoInformado["name"], $contactoInformado["email"], $contactoInformado["phone"]);
            $contacto->insertarContacto($pdo);
            formatearRespuesta(["mensaje" => "Contacto creado", "id" => $contacto->id], 201);
        }
        break;
    }

    case 'PUT':
    {
        if (!$id) formatearRespuesta(["error" => "Falta el parámetro ID"], 400);

        else {
            $contactoInformado = obtenerDatosPeticion();
            if (empty($contactoInformado["name"]) || empty($contactoInformado["phone"]) || empty($contactoInformado["email"])) {
                formatearRespuesta(["error" => "Faltan datos"], 400);
            } else {
                //compruebo que el contacto a actualizar existe
                $contacto = Contacto::obtenerContactoPorId($pdo, $id);
                if (!$contacto) {
                    formatearRespuesta(["error" => "Contacto no existe"], 404);
                } else {
                    $contacto->name = $contactoInformado["name"];
                    $contacto->email = $contactoInformado["email"];
                    $contacto->phone = $contactoInformado["phone"];

                    if ($contacto->modificarContacto($pdo)) {
                        formatearRespuesta(["mensaje" => "Contacto actualizado"], 200);
                    } else {
                        // Si no hubo cambios en los datos, PDO puede devolver 0 filas afectadas
                        formatearRespuesta(["mensaje" => "No se realizaron cambios"], 200);
                    }
                }
            }
        }
        break;
    }

    case 'DELETE':
    {
        if (!$id) formatearRespuesta(["error" => "Falta el parámetro ID"], 400);
        else {
            $contacto = Contacto::obtenerContactoPorId($pdo, $id);
            if (!$contacto) {
                formatearRespuesta(["error" => "Contacto no existe"], 404);
            } else {
                if ($contacto->eliminarContacto($pdo, $id)) {
                    formatearRespuesta(["mensaje" => "Contacto eliminado"], 200);
                } else {
                    formatearRespuesta(["mensaje" => "No se realizaron cambios"], 200);
                }
            }
        }
    }

    default:
    {
        formatearRespuesta(["error" => "Método no permitido"], 405);
        break;
    }
}