async function modificarContacto() {

    let id = document.getElementById('id_modify').value;
    let name = document.getElementById('name_modify').value;
    let email = document.getElementById('email_modify').value;
    let phone = document.getElementById('phone_modify').value;

    try {
        const respuesta = await fetch(`http://localhost/contactos.php?id=${id}`, {
            method: 'PUT',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone
            })
        });

        const resultado = await respuesta.json();

        if (respuesta.ok) {
            // Ajuste: Accedemos a la propiedad "mensaje" del JSON que devuelve tu PHP
            alert("Éxito: " + resultado.mensaje);
            document.getElementById('modify_form').reset();
        } else {
            // Ajuste: Mostramos el error específico que devuelve tu API (ej: "Contacto no existe")
            alert("Error: " + (resultado.error || "Hubo un problema al modificar"));
        }

    } catch (error) {
        alert("Error, revisa la consola!");
        console.error(error);
    }
}

document.getElementById('modify_button').addEventListener('click', modificarContacto);