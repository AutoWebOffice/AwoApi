<?php
/*
 * Подписка контакта на группу подписчиков.
 * Если контакта нет в базе, то он автоматически будет создан.
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// создаем подписку, если ее еще не существует
$result = $api->subscription()->create([
    [
        'last_name' => '', // фамилия
        'name' => '', // имя
        'middle_name' => '', // отчество
        'email' => '', // email - Обязательный параметр
        'password' => '', // пароль для фхода в личный кабинет
        'phone_number' => '', // номер телефона
        'skype' => '', // скайп
        'id_partner' => 0, // ID партнера
        'id_newsletter' => 1, // ID рассылки, на которую надо подписать -  - Обязательный параметр
        'creation_date' => date('Y-m-d H:i:s'), // дата созданиия записи
        'confirmed' => 1, // 1 или 0. Признак подтверждения подписки
        'confirmed_date' => date('Y-m-d H:i:s'), // Дата подтверждения подписки
    ]
]);

if (is_object($result)) {
    // подписка создана или уже существует
    // $result в этом случае - объект подписки
    /*
    stdClass Object
    (
        [id_contact_newsletter_links] => 324
        [id_contact] => 216
        [id_partner] => 1
        [creation_date] => 2019-04-03 08:18:29
        [confirmed] => 1
        [confirmed_date] => 2019-04-03 08:18:29
        [field_1] =>
        [field_2] =>
        [field_3] =>
        [id_advertising_channel_page] => 0
        [advertising_channel_keyword] =>
        [ip_creation] =>
        [advertising_channel_location] =>
        [advertising_channel_type_traffic] =>
        [deleted] => 0
        [deleted_date] => 0000-00-00 00:00:00
        [imported] => 0
        [imported_date] => 0000-00-00 00:00:00
        [id_newsletter] => 1
    )
    */
}
else {
    // подписка не создана
}