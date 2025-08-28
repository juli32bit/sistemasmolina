<?php
$numero1 = $_REQUEST['n1'];
$numero2 = $_REQUEST['n2'];

$multiplicar = isset($_REQUEST['multip']);
$dividir = isset($_REQUEST['dividir']);
$somar = isset($_REQUEST['somar']);
$subtrair = isset($_REQUEST['subtrair']);

function Calculadora($n1, $n2, $multiplicar, $dividir, $somar, $subtrair) {
    if ($multiplicar) {
        return $n1 * $n2;
    } elseif ($dividir) {
        return $n1 / $n2;
    } elseif ($somar) {
        return $n1 + $n2;
    } elseif ($subtrair) {
        return $n1 - $n2;
    } else {
        return "Nenhuma operação selecionada.";
    }
}

if (isset($numero1) && isset($numero2)) {
    $resultado = Calculadora($numero1, $numero2, $multiplicar, $dividir, $somar, $subtrair);
    echo "Resultado: $resultado";
}
?>
