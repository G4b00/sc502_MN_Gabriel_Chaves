<?php include 'app/views/layouts/header.php'; ?>

<div class="d-flex justify-content-center mt-5">
    <div class="card shadow-sm col-md-5">
        <div class="card-header fs-2">
            Crear nueva encuesta
        </div>
        <div class="card-body">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título de la encuesta</label>
                <input type="text" id="titulo" class="form-control" placeholder="Ingrese el título">
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea id="descripcion" class="form-control" rows="3" placeholder="Ingrese la descripción"></textarea>
            </div>

            <h5 class="mb-3">Preguntas</h5>
            <div id="preguntas-container" class="mb-3">
                <div class="input-group mb-2">
                    <span class="input-group-text">1</span>
                    <input type="text" id="pregunta-1" class="form-control" placeholder="Ingrese la pregunta">
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-4" id="agregar-pregunta">Agregar pregunta</button>

            <button type="submit" class="btn btn-primary w-100" onclick="crearEncuesta()">Guardar encuesta</button>
        </div>
    </div>
</div>

<script src="/encuestas/app/public/js/crear.js"></script>

<?php include 'app/views/layouts/footer.php'; ?>
