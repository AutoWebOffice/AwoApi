<?php
/*
 * Получаем всех подписчиков групп(ы) подписчиков
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// получаем всех подписчиков в указанных группах
$results = $api->contact()->getAll([
    'id_newsletter_arr' => [4, 6, 7] // ID групп подписчиков
]);

if (is_array($results) && $results) {
    // есть контакты в этих группах
}
else {
    // ничего не найдено
}