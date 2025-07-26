<?php 

$transacciones = array();
$interes = 0.026;
$cashbackUtil = 0.001;

function registrarTransaccion($id, $descripcion, $monto){
    global $transacciones;
    $newTransaction = array("id" => $id, "descripcion" => $descripcion, "monto" => $monto);
    array_push($transacciones, $newTransaction);
}

function generarEstadoDeCuenta() {
    global $cashbackUtil;
    global $interes;
    global $transacciones;
    $archivo = fopen("estado_cuenta.txt", "w") or die("No se pudo abrir el archivo");
    $total = 0;
    $intereses = 0;
    $cashback = 0;
    $finalToPay = 0;

    $linea = "ID"."----------------"."Descripcion"."----------------"."Monto"."\n";
    fwrite($archivo, $linea);

    $salida = $linea . "<br>";
    foreach ($transacciones as $transaction) {
        $linea = $transaction["id"] ." ----------------- ".$transaction["descripcion"]." ---------------- $".$transaction["monto"]."\n";
        fwrite($archivo, $linea);
        $salida = $salida . $linea . "<br>";
        $total += $transaction["monto"];
    }
    $linea = "\n";
    fwrite($archivo, $linea);
    $salida = $salida . "<br>";
    
    $linea = "TOTAL" . " ----------------------------- $" . $total . "\n";
    fwrite($archivo, $linea);
    $salida = $salida . $linea . "<br>";
    
    $intereses = ($total * $interes) + $total;
    $linea = "TOTAL + INTERES" . " -------------- $" . $intereses . "\n";
    fwrite($archivo, $linea);
    $salida = $salida . $linea . "<br>";
    
    $cashback = $total * $cashbackUtil;
    $linea = "CASHBACK" . " ---------------------- $" . $cashback . "\n";
    fwrite($archivo, $linea);
    $salida = $salida . $linea . "<br>";
    
    $finalToPay = $intereses - $cashback;
    $linea = "TOTAL A PAGAR" . " ---------------- $" . $finalToPay . "\n";
    fwrite($archivo, $linea);
    $salida = $salida . $linea . "<br>";

    echo $salida;
    fclose($archivo);
}

registrarTransaccion(1, "UberEats", 4500);
registrarTransaccion(2, "Nike", 75000);
registrarTransaccion(3, "Fide", 1500);
registrarTransaccion(4, "xd", 450000);

generarEstadoDeCuenta();

?>