let contador = 1;
const btnAgregar = document.getElementById('agregar-pregunta');
const contenedorPreguntas = document.getElementById('preguntas-container');

btnAgregar.addEventListener('click', () => {
    contador++;
    const div = document.createElement('div');
    div.classList.add('input-group', 'mb-2');
    div.innerHTML = `
            <span class="input-group-text">${contador}</span>
            <input type="text" id="pregunta-${contador}" class="form-control" placeholder="Ingrese la pregunta">
        `;
    contenedorPreguntas.appendChild(div);
});

async function crearEncuesta() {
    const txtTitulo = document.getElementById('titulo');
    const txtDescripcion = document.getElementById('descripcion');

    const titulo = txtTitulo.value;
    const descripcion = txtDescripcion.value;
    const preguntas = [];
    let txtPregunta = document.getElementById(`pregunta-1`);

    for (let i = 1; i <= contador; i++) {
        txtPregunta = document.getElementById(`pregunta-${i}`);
        const pregunta = txtPregunta.value;
        preguntas.push(pregunta)
    }

    const encuesta = {
        titulo,
        descripcion,
        preguntas
    }

    await fetch('/encuestas/encuestas/crear', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(encuesta)
    })
        .then(res => res.json())
        .then(data => {
            if (data.message) {
                alert(res.message)
                window.location.href = '/encuestas/encuestas/index';
            } else if (data.error) {
                alert(data.error);
            }
        });

    console.log(encuesta);

}