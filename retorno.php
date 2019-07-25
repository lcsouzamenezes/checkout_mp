<?php

    require_once('config.php');
    require_once('funcoes.php');
    require_once('lib/mercadopago.php');
    
    $mp = new MP (MP_TOKEN);
    $json_event = file_get_contents('php://input', true);
    $event = json_decode($json_event);

    if (!isset($event->type, $event->data) || !ctype_digit($event->data->id)) {
        http_response_code(400);
        return;
    }

    if ($event->type == 'payment'){
        $payment_info = $mp->get('/v1/payments/'.$event->data->id);
        if ($payment_info["status"] == 200) {
            print_r($payment_info["response"]);
            $array = $payment_info["response"];
            file_put_contents('mplog.txt', print_r($array, true));

            getStatus($_GET["id"]))
        }
    }
?>