<?php
class Encuesta
{
    private $pdo;

    public function __construct() {
        $this->pdo = getPDOConnection();
    }

    public function obtenerEncuestas() {
        $stmt = $this->pdo->prepare("SELECT id, id_creador, titulo, descripcion FROM encuestas");
        $stmt->execute();

        $encuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $encuestas;
    }

    public function obtenerEncuesta($idEncuesta) {
        $stmt = $this->pdo->prepare("SELECT id, id_creador, titulo, descripcion FROM encuestas WHERE id=$idEncuesta");
        $stmt->execute();

        $encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmt = $this->pdo->prepare("SELECT * FROM preguntas WHERE id_encuesta = $idEncuesta");
        $stmt->execute();

        $preguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $encuesta["preguntas"] = $preguntas;
        
        return $encuesta;
    }

    public function crearEncuesta($idCreador, $titulo, $descripcion, $preguntas) {
        $stmt = $this->pdo->prepare("INSERT into encuestas (id_creador, titulo, descripcion) values (?, ?, ?)");
        $stmt->execute([$idCreador, $titulo, $descripcion]);

        $idEncuesta = $this->pdo->lastInsertId();
        foreach ($preguntas as $pregunta) {
            $stmt = $this->pdo->prepare("INSERT into preguntas (id_encuesta, texto_pregunta) values (?, ?)");
            $stmt->execute([$idEncuesta, $pregunta]);
        }
    }

    public function responderEncuesta($idUsuario, $respuestas){
        foreach ($respuestas as $resp) {
            $idPregunta = $resp['idPregunta'];
            $valor = $resp['valor'];
            $stmt = $this->pdo->prepare("INSERT INTO respuestas (id_pregunta, id_usuario, valor_respuesta) values (?, ?, ?)");
            $stmt->execute([$idPregunta, $idUsuario, $valor]);
        }
    }
}
