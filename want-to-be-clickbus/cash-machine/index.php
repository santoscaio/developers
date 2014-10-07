<?php
$verMensagem = false;
$mensagem = null;
if ($_POST) {
    $valor = trim($_POST['valor']);
    $verMensagem = true;
    include './class/calculoClass.php';
    $calculoObj = new Calculo();
    $validar = $calculoObj->validarValor($valor);
    if (is_null($validar['erro'])) {
        $mensagem = $calculoObj->calcularNotas($valor, 0);
    } else {
        $mensagem = $validar['erro'];
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <title>Cash Test</title>
    </head>
    <body>
        <form id="saque" method="post">
            <br />
            <label>
            Entre com o valor:
            <br />
            <input id="valor" name="valor" type="text" />
            </label>
            <br />
            <br />
            <button id="sacar" type="submit">Sacar Valor solicitado</button>
        </form>
        <br />
        <br />
        <br />
        <?php
            if (!is_null($mensagem)) {
                echo '<p>Entrada: ' . $valor . '<br />Resultado: ' . $mensagem . '</p>';
            }
        ?>
    </body>
</html>
