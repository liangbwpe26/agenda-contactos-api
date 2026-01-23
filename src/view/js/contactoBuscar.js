async function buscarContacto() {

    let id = document.getElementById('id_modify').value;

    try {
        const respuesta = await fetch(`http://localhost/contactos.php?id=${id}`, {
            method: 'GET',
            headers: {'Content-Type': 'application/json'},
        });

        const resultado = await respuesta.json();

        if (respuesta.ok) {
            // Ajuste: Accedemos a la propiedad "mensaje" del JSON que devuelve tu PHP
            alert("Éxito, contacto encontrado");
        } else {
            // Ajuste: Mostramos el error específico que devuelve tu API (ej: "Contacto no existe")
            alert("Error: " + (resultado.error || "Hubo un problema al buscar el contacto"));
        }

    } catch (error) {
        alert("Error, revisa la consola!");
        console.error(error);
    }
}