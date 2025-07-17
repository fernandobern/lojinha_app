<?php
function enviarWhatsApp($telefone, $nomeTemplate = "hello_world", $params = []) {
    $token = 'SEU_TOKEN_AQUI'; // Idealmente armazenado em .env ou arquivo separado seguro
    $numero_id = 'ID_DO_NUMERO_META';
    
    $url = "https://graph.facebook.com/v18.0/$numero_id/messages";

    $data = [
        "messaging_product" => "whatsapp",
        "to" => $telefone,
        "type" => "template",
        "template" => [
            "name" => $nomeTemplate,
            "language" => ["code" => "pt_BR"]
        ]
    ];

    // Adiciona parâmetros dinâmicos se existirem
    if (!empty($params)) {
        $data["template"]["components"] = [
            [
                "type" => "body",
                "parameters" => $params
            ]
        ];
    }

    $headers = [
        "Authorization: Bearer $token",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $resposta = curl_exec($ch);
    $erro = curl_error($ch);
    curl_close($ch);

    if ($erro) {
        return ['erro' => $erro];
    }

    return json_decode($resposta, true);
}
?>
