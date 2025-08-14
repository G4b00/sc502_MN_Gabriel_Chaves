<?php include 'app/views/layouts/header.php'; ?>

<div class="container">
    <div class="card mb-4 mt-5">
        <div class="card-header">
            <h2 class="mb-0"><?= htmlspecialchars($encuesta['titulo']) ?></h2>
            <small class="text-muted"><?= htmlspecialchars($encuesta['descripcion']) ?></small>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-danger btn-sm" onclick="eliminarEncuesta(<?= $encuesta['id'] ?>)">
                    Eliminar encuesta
                </button>
                <span class="badge bg-primary">
                    <?= $totalRespuestas ?> respuestas
                </span>
            </div>
    
            <?php foreach ($respuestas as $index => $pregunta): ?>
                <div class="mb-4">
                    <h6>
                        Pregunta <?= $index + 1 ?>: <?= htmlspecialchars($pregunta['titulo']) ?>
                    </h6>
    
                    <?php 
                    $total = array_sum(array_column($pregunta['respuestas'], 'total'));
                    foreach ($pregunta['respuestas'] as $respuesta):
                        $porcentaje = $total > 0 ? round(($respuesta['total'] / $total) * 100) : 0;
                    ?>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between">
                                <span><?= htmlspecialchars($respuesta['valor']) ?></span>
                                <span><?= $porcentaje ?>%</span>
                            </div>
                            <div class="progress">
                                <div 
                                    class="progress-bar" 
                                    role="progressbar" 
                                    style="width: <?= $porcentaje ?>%;" 
                                    aria-valuenow="<?= $porcentaje ?>" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script src="/encuestas/app/public/js/ver.js"></script>

<?php include 'app/views/layouts/footer.php'; ?>