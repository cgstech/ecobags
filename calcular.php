<?php
function calcularSubrede($ip, $hosts) {
    // O número total de IPs necessários (inclui rede e broadcast)
    $ips_necessarios = $hosts + 2;

    // Calculando o CIDR (mínimo possível que acomode os hosts desejados)
    $cidr = 32 - ceil(log($ips_necessarios, 2));

    // Convertendo IP para binário
    $ip_binario = '';
    $octetos = explode('.', $ip);
    
    foreach ($octetos as $octeto) {
        $ip_binario .= str_pad(decbin($octeto), 8, '0', STR_PAD_LEFT);
    }

    // Criando a máscara de sub-rede
    $mascara_binaria = str_repeat('1', $cidr) . str_repeat('0', 32 - $cidr);
    $mascara_dec = [];
    
    for ($i = 0; $i < 4; $i++) {
        $mascara_dec[] = bindec(substr($mascara_binaria, $i * 8, 8));
    }

    // Calculando o endereço da rede e de broadcast
    $rede_binaria = substr($ip_binario, 0, $cidr) . str_repeat('0', 32 - $cidr);
    $broadcast_binaria = substr($ip_binario, 0, $cidr) . str_repeat('1', 32 - $cidr);

    $rede_dec = [];
    $broadcast_dec = [];

    for ($i = 0; $i < 4; $i++) {
        $rede_dec[] = bindec(substr($rede_binaria, $i * 8, 8));
        $broadcast_dec[] = bindec(substr($broadcast_binaria, $i * 8, 8));
    }

    return [
        'endereco_rede' => implode('.', $rede_dec),
        'endereco_broadcast' => implode('.', $broadcast_dec),
        'mascara_subrede' => implode('.', $mascara_dec),
        'cidr' => $cidr,
        'quantidade_ips' => pow(2, (32 - $cidr)) - 2
    ];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ip = $_POST['ip'];
    $hosts = (int)$_POST['hosts'];

    if (filter_var($ip, FILTER_VALIDATE_IP) && $hosts >= 2) {
        $resultado = calcularSubrede($ip, $hosts);
    } else {
        die("IP inválido ou número de hosts insuficiente.");
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Sub-rede</title>
</head>
<body>
    <h2>Resultados do Cálculo</h2>
    <p><strong>Endereço da Rede:</strong> <?= $resultado['endereco_rede'] ?></p>
    <p><strong>Endereço de Broadcast:</strong> <?= $resultado['endereco_broadcast'] ?></p>
    <p><strong>Máscara de Sub-rede:</strong> <?= $resultado['mascara_subrede'] ?> ( /<?= $resultado['cidr'] ?> )</p>
    <p><strong>Quantidade de IPs utilizáveis:</strong> <?= $resultado['quantidade_ips'] ?></p>
    <a href="index.html">Voltar</a>
</body>
</html>
