async function crearContacto(event) {
    event.preventDefault();

    let name = document.getElementById('name').value;
    let email = document.getElementById('email').value;
    let phone = document.getElementById('phone').value;

    try {
        const respuesta = await fetch('http://localhost/contactos.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                name: name,
                email: email,
                phone: phone
            })
        });
        if (respuesta.ok) {
            const resultado = await respuesta.json();
            alert("Contacto añadido: " + resultado);
            document.getElementById('form_contact').reset();
        } else {
            alert("Hubo algo mal al crear el contacto");
        }
    } catch (error) {
        alert("Error, revisa la consola!");
        console.error(error);
    }
}

document.getElementById('send_contact').addEventListener('click', crearContacto);