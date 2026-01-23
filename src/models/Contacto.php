<?php

/**
 * Clase Contacto
 *
 * Representa un contacto con propiedades como ID, nombre, correo electrónico y teléfono.
 * Proporciona métodos estáticos para interactuar con la base de datos.
 * y métodos de instancia para la gestión de propiedades.
 *
 * @package AgendaContactos
 * @author Liang Benalcazar
 * @version 1.0.0
 */
class Contacto
{
    /** @var int El ID único del contacto. */
    private $id;
    /** @var string El nombre del contacto. */
    private $name;
    /** @var string La dirección de correo electrónico del contacto. */
    private $email;
    /** @var string El número de teléfono del contacto. */
    private $phone;

    /**
     * Constructor de la clase Contacto.
     * @param string $name
     * @param string $email
     * @param string $phone
     */
    public function __construct($name, $email, $phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
    }

    /**
     * Getter mágico para acceder a propiedades privadas.
     * * @param string $property Nombre de la propiedad.
     * @return mixed Valor de la propiedad o null si no existe.
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        return null;
    }

    /**
     * Setter mágico para modificar propiedades privadas.
     * * @param string $property Nombre de la propiedad.
     * @param mixed $value Nuevo valor.
     * @return $this
     */
    public function __set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return $this;
    }

    /**
     * Inserta un nuevo contacto en la base de datos.
     *
     * @param Object $pdo Objeto PDO para la conexión.
     * @param string $name Nombre del contacto.
     * @param string $email Correo electrónico.
     * @param string $phone Teléfono.
     * @return bool True si la inserción fue exitosa.
     */
    public function insertarContacto($pdo): bool
    {
        try {
            $sql = "INSERT INTO contactos (name, email, phone) VALUES(:name, :email, :phone)";
            $stmt = $pdo->prepare($sql);
            $ejecutado = $stmt->execute([
                ":name" => $this->name,
                ":email" => $this->email,
                ":phone" => $this->phone
            ]);

            if ($ejecutado) {
                // Obtenemos el último ID generado en esta conexión y lo seteamos en el objeto
                $this->id = $pdo->lastInsertId();
                return true;
            }

            return false;

        } catch (PDOException $e) {
            error_log("Error al insertar: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Obtiene todos los contactos de la base de datos.
     *
     * @param Object $pdo Objeto PDO para la conexión.
     * @return array Lista de contactos (cada uno como array asociativo).
     */
    public static function mostrarContactos($pdo): array
    {
        $sql_select = "SELECT * FROM contactos ORDER BY id DESC";
        $stmt_select = $pdo->query($sql_select);
        return $stmt_select->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene un contacto específico por su ID.
     *
     * @param Object $pdo Objeto PDO para la conexión.
     * @param int $id ID del contacto.
     * @return Contacto Array con datos del contacto o false si no existe.
     */
    public static function obtenerContactoPorId($pdo, $id)
    {
        $sql = "SELECT * FROM contactos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([":id" => $id]);

        $datos = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$datos) {
            return null; // Si no hay datos, devolvemos null
        }

        // Creamos el objeto directamente con los datos obtenidos
        $contacto = new Contacto($datos["name"], $datos["phone"], $datos["email"]);
        $contacto->id = $id; // Importante para que el PUT sepa qué ID a actualizar

        return $contacto;
    }

    /**
     * Modifica un contacto existente utilizando los datos de la instancia.
     *
     * @param PDO $pdo Objeto PDO para la conexión.
     * @return bool True si se actualizó al menos una fila.
     */
    public function modificarContacto($pdo): bool
    {
        try {
            $sql = "UPDATE contactos SET name = :name, email = :email, phone = :phone WHERE id = :id";
            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":id" => $this->id,
                ":name" => $this->name,
                ":email" => $this->email,
                ":phone" => $this->phone
            ]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Elimina un contacto por su ID.
     *
     * @param PDO $pdo Objeto PDO para la conexión.
     * @param int $id ID del contacto a eliminar.
     * @return bool True si se eliminó correctamente.
     */
    public static function eliminarContacto($pdo, $id): bool
    {
        try {
            $sql = "DELETE FROM contactos WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([":id" => $id]);

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}