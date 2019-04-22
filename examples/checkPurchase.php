<?php
/*
 * Проверка покупки (покупал ли контакт, указанный товар)
 * Поиск покупки определенного товара в списке покупок определенного контакта
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// проверка по ID контакта
$result = $api->contact()->getAll([
    'idGoods' => [6], // ID товаров, которые надо проверить
    'id_contact' => 204 // ID контакта
]);

if (is_array($result) && $result) {
    // Контакт покупал этот товар
}
else {
    // Контакт не покупал этот товар;
}

// проверка по email контакта
$result = $api->contact()->getAll([
    'idGoods' => [6], // ID товаров, которые надо проверить
    'email' => 'mail@example.com' // ID контакта
]);

if (is_array($result) && $result) {
    // Контакт покупал этот товар
}
else {
    // Контакт не покупал этот товар;
}
