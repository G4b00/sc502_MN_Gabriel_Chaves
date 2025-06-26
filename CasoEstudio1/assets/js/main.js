document.addEventListener('DOMContentLoaded', function () {

    cargarEstudiantes();

    const btn = document.querySelector('#btn_crear_estudiante');
    btn.addEventListener('click', crearEstudiante);

});

const estudiantes = [
    {
        name: "María",
        lastname: "Mora Perez",
        calification: 90
    },
    {
        name: "Pedro",
        lastname: "Sibaja Lopez",
        calification: 60
    },
    {
        name: "Marco",
        lastname: "Rojas Castro",
        calification: 78
    }
];

const crearEstudiante = () => {
    console.log("se crea tarjeta");

    const form = document.querySelector('#form');
    const formData = new FormData(form);

    const entries = Object.fromEntries(formData.entries());
    const { name, lastname, calification } = entries;
    const divAlert = document.getElementById('alerta');
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


    if (lastname === '' || name === '' || calification === '') {
        appendAlert('No puedes dejar campos vacios', 'danger')
        return;
    }
    if (calification < 0 || calification > 100) {
        appendAlert('La calificacion no puede ser menor a 0 o mayor que 100', 'danger')
        return;
    }

    const nuevoEstudiante = {
        name,
        lastname,
        calification
    };

    const lsEstudiantes = localStorage.getItem('estudiantes');
    const estudianteObj = JSON.parse(lsEstudiantes);
    estudianteObj.push(nuevoEstudiante);
    form.reset();
    localStorage.setItem('estudiantes', JSON.stringify(estudianteObj));
    cargarEstudiantes();
};

const cargarEstudiantes = () => {
    const tbody = document.querySelector('#table-body');
    tbody.innerHTML = '';

    let localStorageEstudiantes = localStorage.getItem('estudiantes');

    if (localStorageEstudiantes == null) {
        localStorage.setItem("estudiantes", JSON.stringify(estudiantes));
        localStorageEstudiantes = localStorage.getItem('estudiantes');
    }


    let estudiantesObject = JSON.parse(localStorageEstudiantes);
    estudiantesObject.forEach(estudiante => {
        console.log(estudiante);

        const { name, lastname, calification } = estudiante;

        const tr = document.createElement('tr');

        const tdname = document.createElement('td');
        tdname.innerHTML = name;

        const tdLastName = document.createElement('td');
        tdLastName.innerHTML = lastname;

        tdCalification = document.createElement('td');
        tdCalification.innerHTML = calification;

        let tdCalificationClass = '';

        if (calification >= 80) {
            tdCalificationClass = 'table-success';
        } else if (calification < 60) {
            tdCalificationClass = 'table-danger';
        } else {
            tdCalificationClass = 'table-light';
        }

        tdCalification.classList.add(tdCalificationClass);


        tr.appendChild(tdname);
        tr.appendChild(tdLastName);
        tr.appendChild(tdCalification)
        tbody.appendChild(tr)
    });

};