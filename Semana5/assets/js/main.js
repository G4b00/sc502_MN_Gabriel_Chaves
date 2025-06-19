document.addEventListener('DOMContentLoaded', function(){
    console.log('Cargó mi página');

    cargarTarjetas();

    const btn = document.querySelector('#btn_crear_tarjeta');
    btn.addEventListener('click', crearTarjeta);

});

const tarjetas = [
    {
        img:'assets/img/largometraje-de-chopper-one-piece.jpg',
        title:'Chopper',
        description:'Chopper Llorando',
        boton:'Boton Chopper'
    },
    {
        img:'assets/img/zoro.jpg',
        title:'Zoro',
        description:'Zoro pichudo',
        boton:'Boton Zoro'
    },
    {
        img:'assets/img/robin.jpg',
        title:'Robin',
        description:'Robin Magestic',
        boton:'Boton Robin'
    },
    
];

const crearTarjeta = () => {
    console.log("se crea tarjeta")

    const form = document.querySelector('#formulario');
    const formData = new FormData(form);

    const entries = Object.fromEntries(formData.entries());
    const {img, title, description, boton} = entries;
    
    const nuevaTarjeta = {
        img,
        title,
        description,
        boton
    };

    tarjetas.push(nuevaTarjeta)
    form.reset();
    localStorage.setItem('tarjetas', JSON.stringify(tarjetas))
    cargarTarjetas()
    
};

const cargarTarjetas = () => {
    
    const tarjetas_section = document.querySelector('#tarjetas_section');
    tarjetas_section.innerHTML = '';

    
    const localStorageTarjetas = localStorage.getItem('tarjetas');
    
    if(localStorageTarjetas == null){
        localStorage.setItem('tarjetas', JSON.stringify(tarjetas));
    }

    console.log("Tarjetas obtenidas lstrg: ", localStorageTarjetas);

    let tarjetasObject = JSON.parse(localStorageTarjetas);


    tarjetasObject.forEach(tarjeta => {
        console.log(tarjeta);


        const {img, title, description, boton} = tarjeta
        const col = document.createElement('div');
        col.classList.add('col-4');
        col.classList.add('mb-3')
        
        col.innerHTML = `<div class="card" style="width: 18rem;">
                    <img src="${img}" class="card-img-top" alt="Chopper-llorando">
                    <div class="card-body">
                        <h5 class="card-title">${title}</h5>
                        <p class="card-text">${description}</p>
                        <a href="#" class="btn btn-primary">${boton}</a>
                    </div>
                </div>`;
        tarjetas_section.appendChild(col);
    });

    console.log(tarjetas_section);
};