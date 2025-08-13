<?php

class EncuestasController
{
    public function index()
    {
        $model = new Encuesta();
        $encuestas = $model->obtenerEncuestas();

        require __DIR__ . "/../views/encuestas/index.php";
    }

    public function crear()
    {
        $model = new Encuesta();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $model = new Encuesta();

            // Leer el body como JSON
            $input = json_decode(file_get_contents('php://input'), true);

            $idCreador = $_SESSION['user_id'] ?? null;
            $titulo = $input['titulo'] ?? '';
            $descripcion = $input['descripcion'] ?? '';
            $preguntas = $input['preguntas'] ?? [];

            // Validar
            if (!$idCreador || empty($titulo) || empty($descripcion) || empty($preguntas)) {
                http_response_code(400);
                echo json_encode(['error' => 'Todos los campos son obligatorios']);
                return;
            }

            // Insertar encuesta y preguntas
            $model->crearEncuesta($idCreador, $titulo, $descripcion, $preguntas);

            // Responder con éxito
            http_response_code(201);
            echo json_encode(['message' => 'Encuesta creada correctamente']);

        } else {
            require __DIR__ . "/../views/encuestas/crear/index.php";
        }
    }

    public function ver($idEncuesta)
    {
        $model = new Encuesta();
        $encuesta = $model->obtenerEncuesta($idEncuesta);

        require __DIR__ . "/../views/encuestas/ver/index.php";

    }

    public function responder($idEncuesta)
    {
        $model = new Encuesta();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json'); // Forzar JSON
            try {
                $input = json_decode(file_get_contents('php://input'), true);

                if (!$input) {
                    http_response_code(400);
                    echo json_encode(['error' => 'Datos JSON inválidos']);
                    exit;
                }

                $respuestas = $input['respuestas'] ?? [];
                $idUsuario = $_SESSION['user_id'] ?? null;

                if (!$idUsuario) {
                    http_response_code(401);
                    echo json_encode(['error' => 'Usuario no autenticado']);
                    exit;
                }

                if (empty($respuestas)) {
                    http_response_code(400);
                    echo json_encode(['error' => 'No se enviaron respuestas']);
                    exit;
                }

                // Guardar respuestas
                $model->responderEncuesta($idUsuario, $respuestas);

                http_response_code(200);
                echo json_encode(['message' => 'Respuestas guardadas correctamente']);

            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
            }
        } else {
            // Mostrar vista si es GET
            $encuesta = $model->obtenerEncuesta($idEncuesta);
            require __DIR__ . "/../views/encuestas/responder/index.php";
        }
    }


    public function guardarRespuesta()
    {
        $model = new Encuesta();

    }
}
