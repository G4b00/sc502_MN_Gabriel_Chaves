<?php
class Encuesta
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDOConnection();
    }

    public function obtenerEncuestas()
    {
        $stmt = $this->pdo->prepare("SELECT id, id_creador, titulo, descripcion FROM encuestas");
        $stmt->execute();

        $encuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $encuestas;
    }

    public function obtenerEncuesta($idEncuesta)
    {
        $stmt = $this->pdo->prepare("SELECT id, id_creador, titulo, descripcion FROM encuestas WHERE id=$idEncuesta");
        $stmt->execute();

        $encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT * FROM preguntas WHERE id_encuesta = $idEncuesta");
        $stmt->execute();

        $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $encuesta["preguntas"] = $preguntas;

        return $encuesta;
    }

    public function crearEncuesta($idCreador, $titulo, $descripcion, $preguntas)
    {
        $stmt = $this->pdo->prepare("INSERT into encuestas (id_creador, titulo, descripcion) values (?, ?, ?)");
        $stmt->execute([$idCreador, $titulo, $descripcion]);

        $idEncuesta = $this->pdo->lastInsertId();
        foreach ($preguntas as $pregunta) {
            $stmt = $this->pdo->prepare("INSERT into preguntas (id_encuesta, texto_pregunta) values (?, ?)");
            $stmt->execute([$idEncuesta, $pregunta]);
        }
    }

    public function responderEncuesta($idUsuario, $respuestas)
    {
        foreach ($respuestas as $resp) {
            $idPregunta = $resp['idPregunta'];
            $valor = $resp['valor'];
            $stmt = $this->pdo->prepare("INSERT INTO respuestas (id_pregunta, id_usuario, valor_respuesta) values (?, ?, ?)");
            $stmt->execute([$idPregunta, $idUsuario, $valor]);
        }
    }

    public function obtenerRespuestas($preguntas)
    {
        $respuestas = [];

        foreach ($preguntas as $index => $pregunta) {
            $idPregunta = $pregunta["id"];
            $respuestasPregunta = [];

            for ($i = 1; $i <= 5; $i++) {
                $stmt = $this->pdo->prepare("SELECT COUNT(*) AS total FROM respuestas WHERE id_pregunta = ? AND valor_respuesta = ?");
                $stmt->execute([$idPregunta, $i]);
                $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

                $respuestasPregunta[] = ['valor' => $i, 'total' => $total];
            }

            $respuestas[$index] = [
                'id' => $idPregunta,
                'titulo' => $pregunta['texto_pregunta'] ?? '',
                'respuestas' => $respuestasPregunta
            ];
        }

        return $respuestas;
    }


    public function getTotalRespuestas($pregunta)
    {
        $total = 0;
        $idPregunta = $pregunta["id"];

        // Total de respuestas para esa pregunta
        $stmtTotal = $this->pdo->prepare("SELECT COUNT(*) as total FROM respuestas WHERE id_pregunta = ?");
        $stmtTotal->execute([$idPregunta]);
        $total = (int) $stmtTotal->fetch(PDO::FETCH_ASSOC)['total'];

        return $total;
    }

    public function eliminarEncuesta($idEncuesta){
        $stmtTotal = $this->pdo->prepare("DELETE FROM encuestas WHERE id = ?");
        $stmtTotal->execute([$idEncuesta]);
    }
}
