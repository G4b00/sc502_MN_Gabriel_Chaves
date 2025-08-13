<?php include 'app/views/layouts/header.php'; ?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body ">
                    <h5 class="card-title">Opciones</h5>
                    <a href="crear" class="btn btn-success w-100 mt-3">
                        <i class="bi bi-plus-lg"></i> Nueva encuesta
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9">

            <div class="card shadow-sm mb-4">
                <div class="card-header fs-2">
                    Mis encuestas creadas
                </div>
                <div class="p-3">
                    <div class="list-group">

                        <?php foreach ($encuestas as $encuesta): ?>
                            <?php if ($encuesta['id_creador'] === $_SESSION['user_id']): ?>
                                <a href="ver?idEncuesta=1"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><?php echo $encuesta['titulo'] ?></span>
                                    <span class="badge rounded-pill bg-primary">Ver resultados</span>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header fs-2">
                    Encuestas disponibles para responder
                </div>
                <div class="p-3">
                    <div class="list-group">
                        <?php foreach ($encuestas as $encuesta): ?>
                            <?php if ($encuesta['id_creador'] != $_SESSION['user_id']): ?>
                                <a href="#"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    <span><?php echo $encuesta['titulo'] ?></span>
                                    <span class="badge rounded-pill bg-success">Responder</span>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<?php include 'app/views/layouts/footer.php'; ?>