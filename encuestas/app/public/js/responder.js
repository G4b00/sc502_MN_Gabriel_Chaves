document.getElementById('formEncuesta').addEventListener('submit', function(e) {
    e.preventDefault(); // Evita que el form recargue la página

    const form = e.target;
    const idEncuesta = form.querySelector('input[name="id_encuesta"]').value;

    const respuestas = [];

    console.log(idEncuesta);
    console.log(respuestas);
    
    

    // Recorremos todos los grupos de radio por cada pregunta
    const grupos = form.querySelectorAll('input[type="radio"]:checked');
    grupos.forEach(radio => {
        const idPregunta = radio.name.match(/\d+/)[0]; // extrae el id de la pregunta del name
        respuestas.push({
            idPregunta: parseInt(idPregunta),
            valor: parseInt(radio.value)
        });
    });

    // Enviar con fetch
    fetch(`/encuestas/encuestas/responder/${idEncuesta}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ respuestas }),
        credentials: 'include' // importante si usas sesión
    })
    .then(res => res.json())
    .then(data => {
        if (data.message) {
            alert(data.message);
            window.location.href = '/encuestas/encuestas/index';
        } else if (data.error) {
            alert(data.error);
        }
    })
    .catch(err => console.error('Error:', err));
});
