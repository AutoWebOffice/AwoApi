<?php
/*
 * Перенос подписчика из одной группы в другую
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// ищем контакт по email
$contact = $api->contact()->getAll([
    'email' => 'mail@example.com',
]);

if (!is_array($contact) || !$contact) {
    echo 'контакт не найден';
    return;
}

$idContact = $contact[0]->id_contact;

// ищем подписку для этого контакта на указанную группу
$subscriber = $api->subscriber()->getAll([
    'id_contact' => $idContact,
    'id_newsletter' => 3 // ID группы подписчиков
]);

if (!is_array($subscriber) || !$subscriber) {
    echo 'подписка не найдена';
    return;
}

// удаляем найденную подписку
$api->subscriber()->delete($subscriber[0]->id_contact_newsletter_links);

// будем подписывать контакта на группу подписчиков в ID 18
$idNewsletter = 18;

// ищем уже существующую подписку
$subscriber = $api->subscriber()->getAll([
    'id_contact' => $idContact,
    'id_newsletter' => $idNewsletter,
]);

if (is_array($subscriber) && $subscriber) {
    echo 'подписка уже существует';
    return;
}

// создаем новую подписку
$subscriber = $api->subscriber()->create([
    [
        'id_contact' => $idContact,
        'id_partner' => 0,
        'creation_date' => date('Y-m-d H:i:s'),
        'confirmed' => 1,
        'confirmed_date' => date('Y-m-d H:i:s'),
        'id_advertising_channel_page' => 0,
        'advertising_channel_keyword' => '',
        'advertising_channel_location' => '',
        'advertising_channel_type_traffic' => '',
        'id_newsletter' => $idNewsletter,
    ]
]);

if (is_object($subscriber)) {
    // подписка создана
    // $subscription = объект с данными новой подписки
    /*
    stdClass Object
    (
        [id_contact] => 204
        [id_newsletter] => 5
        [id_partner] => 0
        [confirmed] => 1
        [id_advertising_channel_page] => 0
        [deleted] => 0
        [imported] => 0
        [creation_date] => 2019-04-03 09:14:37
        [confirmed_date] => 2019-04-03 09:14:37
        [advertising_channel_keyword] =>
        [advertising_channel_location] =>
        [advertising_channel_type_traffic] =>
        [field_1] =>
        [field_2] =>
        [field_3] =>
        [id_contact_newsletter_links] => 325
        [ip_creation] =>
        [deleted_date] =>
        [imported_date] =>
    )
    */
}
