<?php
/*
 * Добавление метки к контакту
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// добавляем метку
$result = $api->contactTagLnk()->create([
    [
        'id_contact' => '1', // код контакта в АВО
        'id_contact_tag' => '1', // код созданной в АВО метки
    ]
]);

if (is_object($result)) {
    var_dump($result);
}
else {
    // метка не присвоена
}