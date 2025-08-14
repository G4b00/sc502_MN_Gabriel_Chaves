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

            $input = json_decode(file_get_contents('php://input'), true);

            $idCreador = $_SESSION['user_id'] ?? null;
            $titulo = $input['titulo'] ?? '';
            $descripcion = $input['descripcion'] ?? '';
            $preguntas = $input['preguntas'] ?? [];

            if (!$idCreador || empty($titulo) || empty($descripcion) || empty($preguntas)) {
                http_response_code(400);
                echo json_encode(['error' => 'Todos los campos son obligatorios']);
                return;
            }

            $model->crearEncuesta($idCreador, $titulo, $descripcion, $preguntas);

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

        $preguntas = $encuesta['preguntas'];

        $respuestas = $model->obtenerRespuestas($preguntas);

        $totalRespuestas = $model->getTotalRespuestas($preguntas[0]);
        // echo json_encode($preguntas);
        // print_r($respuestas);
        // echo json_encode($respuestas);

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

                $model->responderEncuesta($idUsuario, $respuestas);

                http_response_code(200);
                echo json_encode(['message' => 'Respuestas guardadas correctamente']);

            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode(['error' => 'Ocurrió un error al guardar: ' . $e->getMessage()]);
            }
        } else {
            $encuesta = $model->obtenerEncuesta($idEncuesta);
            require __DIR__ . "/../views/encuestas/responder/index.php";
        }
    }

    public function eliminar($idEncuesta)
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405); 
            echo json_encode(["error" => "Método no permitido"]);
            return;
        }

        // $idEncuesta = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($idEncuesta <= 0) {
            http_response_code(400);
            echo json_encode(["success" => false, "error" => "ID de encuesta inválido"]);
            return;
        }

        $model = new Encuesta();
        $model->eliminarEncuesta($idEncuesta);

        http_response_code(200);
        echo json_encode(["success" => true, "message" => "Encuesta eliminada correctamente"]);
    }


}
