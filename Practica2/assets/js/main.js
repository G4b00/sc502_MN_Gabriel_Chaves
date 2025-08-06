document.addEventListener('DOMContentLoaded', function () {

    cargarEstudiantes();

    const btnCalcular = document.querySelector('#calcular-deduccion');
    btnCalcular.addEventListener('click', calcularDeduccion);

    const btnCambiar = document.querySelector("#cambiar");
    btnCambiar.addEventListener('click', cambiarParrafo);

    const btnCalcularEdad = document.querySelector('#calcular-edad');
    btnCalcularEdad.addEventListener('click', calcularEdad);

});

const estudiantes = [
    {
        nombre: "Carlos",
        apellidos: "Ramírez Gómez",
        nota: 87
    },
    {
        nombre: "María",
        apellidos: "Fernández Soto",
        nota: 92
    },
    {
        nombre: "Luis",
        apellidos: "Castillo Vargas",
        nota: 76
    },
    {
        nombre: "Ana",
        apellidos: "Morales Jiménez",
        nota: 64
    },
    {
        nombre: "José",
        apellidos: "Pérez Salas",
        nota: 95
    }
];


const calcularDeduccion = () => {
    const form = document.querySelector('#form-deduccion');
    const formData = new FormData(form);

    const entries = Object.fromEntries(formData.entries());
    let { salario } = entries;

    const porcentajeCargasSociales = 0.1034;
    const cargasSociales = salario * porcentajeCargasSociales;

    let impuestoRenta = 0;

    if (salario > 4845000) {
        impuestoRenta += (salario - 4845000) * 0.25;
        salario = 4845000;
    }
    if (salario > 2423000) {
        impuestoRenta += (salario - 2423000) * 0.20;
        salario = 2423000;
    }
    if (salario > 1381000) {
        impuestoRenta += (salario - 1381000) * 0.15;
        salario = 1381000;
    }
    if (salario > 941000) {
        impuestoRenta += (salario - 941000) * 0.10;
    }

    // 3. Salario neto
    const salarioNeto = salario - cargasSociales - impuestoRenta;

    const card = document.createElement('div');
    card.classList.add('card');

    const ul = document.createElement('ul');
    ul.classList.add('list-group');
    ul.classList.add('list-group-flush');

    const li = document.createElement('li');
    li.classList.add('list-group-item');
    li.innerHTML = `Cargas sociales: ${cargasSociales}`

    const li2 = document.createElement('li');
    li2.classList.add('list-group-item');
    li2.innerHTML = `Impuesto sobre renta: ${impuestoRenta}`

    const li3 = document.createElement('li');
    li3.classList.add('list-group-item');
    li3.innerHTML = `Salario Neto: ${salarioNeto}`

    ul.appendChild(li);
    ul.appendChild(li2);
    ul.appendChild(li3);
    
    card.appendChild(ul);

    const calculos = document.getElementById('calculos')
    calculos.innerHTML = '';
    calculos.appendChild(card)

    console.log(cargasSociales)
    console.log(impuestoRenta)
    console.log(salarioNeto)


};

const cambiarParrafo = () => {
    console.log('cambiar parrafo sirve');
    const parrafo = document.getElementById('parrafo');
    parrafo.innerHTML = 'contenido del parrafo parrafo cambiado';
};

const calcularEdad = () => {
    const formEdad = document.getElementById('form-edad');
    const formEdadData = new FormData(formEdad);

    const entries = Object.fromEntries(formEdadData.entries());

    const { edad } = entries;


    const divAlert = document.getElementById('div-alert');
    divAlert.innerHTML = '';

    const appendAlert = (message, type) => {
        const wrapper = document.createElement('div');
        wrapper.innerHTML = [
            `<div class="alert alert-${type} alert-dismissible" role="alert">`,
            `   <div>${message}</div>`,
            '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
            '</div>'
        ].join('');

        divAlert.appendChild(wrapper);
    }

    if (edad === '') {
        appendAlert('Ingresa una edad', 'primary')
        return;
    }

    if (edad >= 18) {
        appendAlert('Eres mayor de edad', 'primary')
    } else {
        appendAlert('Eres menor de edad', 'primary')
    }
};

const cargarEstudiantes = () => {

    const ejercicio4 = document.getElementById('ejercicio4');

    const card = document.createElement('div');
    card.classList.add('card');

    const ul = document.createElement('ul');
    ul.classList.add('list-group');
    ul.classList.add('list-group-flush');

    let promedio = 0;

    estudiantes.forEach(estudiante => {
        const li = document.createElement('li');
        li.classList.add('list-group-item');
        li.innerHTML = `${estudiante.nombre} ${estudiante.apellidos} tiene nota de: ${estudiante.nota}`

        promedio += estudiante.nota;

        ul.appendChild(li);
    });

    promedio = promedio / estudiantes.length;

    const cardFooter = document.createElement('div');
    cardFooter.classList.add('card-footer');
    cardFooter.innerHTML = `Promedio de notas: ${promedio}`;

    card.appendChild(ul);
    card.appendChild(cardFooter);

    ejercicio4.appendChild(card)
};