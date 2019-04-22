<?php
/*
 * Проверка подписки
 * Поиск контакта в определенной группе или группах
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// проверяем, находится ли контакт с конкретным ID в одной из указанных групп подписчиков
$results = $api->contact()->getAll([
    'id_contact' => 18, // ID контакта
    'id_newsletter_arr' => [4, 6, 7], // ID групп подписчиков
]);

if (is_array($results) && $results) {
    // Контакт найден в группе;
}
else {
    // Контакт не найден в группе;
}


// проверяем, находится ли контакт с указанным email в одной из указанных групп подписчиков
$results = $api->contact()->getAll([
    'email' => 'example@yandex.ru', // email контакта
    'id_newsletter_arr' => [4, 6, 7], // ID групп подписчиков
]);

if (is_array($results) && $results) {
    // Контакт найден в группе;
}
else {
    // Контакт не найден в группе;
}