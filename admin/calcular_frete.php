<?php
session_start();

$cep_origem = $_POST['cep_origem'];
$cep_destino = $_POST['cep_destino'];
$peso = $_POST['peso'];
$comprimento = $_POST['comprimento'];
$altura = $_POST['altura'];
$largura = $_POST['largura'];
$valor_declarado = $_POST['valor_declarado'];

$url = 'https://www.melhorenvio.com.br/api/v2/me/shipment/calculate';

$data = [
    'from' => [
        'postal_code' => $cep_origem
    ],
    'to' => [
        'postal_code' => $cep_destino
    ],
    'products' => [
        [
            'weight' => $peso,
            'width' => $largura,
            'height' => $altura,
            'length' => $comprimento,
            'insurance_value' => $valor_declarado,
            'quantity' => 1
        ]
    ],
    'services' => [], 
    'options' => [
        'receipt' => false, 
        'own_hand' => false, 
        'collect' => false 
    ],
    'insurance_value' => $valor_declarado
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    //token
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODgzMTI3YjBkYTUyYzM0MjU1Mzk3ZDEwMTg5NjY2ZGUyYzgyZWU4OWY5OGQwMjFjOTBkNjE5YzFhYjc1NmZhNGFiMDg4Yzk2N2E4MjBmYWUiLCJpYXQiOjE3MjcxNzk3ODIuNDcxOTQxLCJuYmYiOjE3MjcxNzk3ODIuNDcxOTQyLCJleHAiOjE3NTg3MTU3ODIuNDU3ODM3LCJzdWIiOiJlYjIxMzlmYy1hNmExLTRlYTgtYTQxMy1mMWJmZjQwZWY3NzQiLCJzY29wZXMiOlsic2hpcHBpbmctY2FsY3VsYXRlIl19.t_zsUoSS7oMyuBxK6V0APWePku1bu8pPGLFvbnquBgJsPqYhk7gc9yCSgKNJx84aVZhNXWXvGQIyaNF-TIRxL_wQalx6Y8BtuHkLky_d8rpQHpIp9XLVABIaXbjONSek7hp3cPAdlmf5iLM3SfWew-KUS6n-KfCAfopPObYFLuyKQ68MbaiU9veCnI5_mJG-a9YWmYuVg7kvB0HA4FO2D9aVWTxi_RkmVMhNrqF-unxCgfNWSDQUe6i74ol-TwRgYEYSW0t6nDktiyiAwy78yc6ESIKdimXHtv-_30Gm71zzGAaVD_2-ZwP3IKHH17Xz7vZD-JYv5wUrY8B_GSNGDllfzvKK1kKJ-KW_GoY_3mByhab4QDQDa-kMGFs8iEcD1i7SyxhE945e6WTDDDwia18VUF6098cgEoNu6t6CpavaqU5FD-bwg_itS0cjLq5kpT3nU9mq-650K-5SL7gu4yCLhZvvZ530xMc31_Cmx70JQiYGN4pgqPkdC96ANzOVkY25bCcVoeJPMtOZcypeGh4w-kL2w7uS7HzKc8HUj2KRS5bVi099tqPzikyL19yYLY8xhJ1oeqc0ofml7o4OOpauGqlaWr5JrT_y_pFOn5oLgDVw4vwCB84kmnjnOHiwY8rZaJaR77pdrugiXqoz1bcZhWDMlmOqK_Cow9Y-GyA'  
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Erro ao consultar a API do Melhor Envio: ' . curl_error($ch);
} else {
    $resultado = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        echo 'Erro ao decodificar a resposta JSON: ' . json_last_error_msg();
    }

    $servicos_validos = array_filter($resultado, function($servico) {
        return !isset($servico['error']);
    });

    if (!empty($servicos_validos)) {
        $_SESSION['resultado_frete'] = $servicos_validos;
        header('Location: exibir_frete.php');
        exit();
    } else {
        echo 'Nenhum serviço disponível para o cálculo de frete.';
    }
}

curl_close($ch);
