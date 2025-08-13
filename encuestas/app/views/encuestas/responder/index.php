<?php include 'app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <!-- Título de la encuesta -->
    <h1 class="mb-3"><?= htmlspecialchars($encuesta['titulo']) ?></h1>
    
    <!-- Descripción -->
    <p class="text-muted"><?= htmlspecialchars($encuesta['descripcion']) ?></p>
    
    <form id="formEncuesta">
        <input type="hidden" name="id_encuesta" value="<?= $encuesta['id'] ?>">

        <?php foreach ($encuesta['preguntas'] as $index => $pregunta): ?>
            <div class="mb-4 p-3 border rounded bg-white">
                <h5><?= ($index + 1) . ". " . htmlspecialchars($pregunta['texto_pregunta']) ?></h5>
                <div class="mt-2">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" 
                                   name="respuestas[<?= $pregunta['id'] ?>]" 
                                   id="pregunta<?= $pregunta['id'] ?>_<?= $i ?>" 
                                   data-idrespuesta=<?= $i ?>
                                   value="<?= $i ?>" required>
                            <label class="form-check-label" for="pregunta<?= $pregunta['id'] ?>_<?= $i ?>">
                                <?= $i ?>
                            </label>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <button type="submit" class="btn btn-primary">Enviar Respuestas</button>
    </form>
</div>

<script src="/encuestas/app/public/js/responder.js"></script>


<?php include 'app/views/layouts/footer.php'; ?>