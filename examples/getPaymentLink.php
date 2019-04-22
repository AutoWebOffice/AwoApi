<?php
/*
 * Получение ссылки на оплату счета
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// получаем объект существующего счета по его ID (370224)
$result = $api->invoice()->get(370224);

if (is_object($result)) {
    // счет найден.

    // ссылка на оплату находится в свойстве 'link_for_pay'
    $paymentLink = $result->link_for_pay;
}
