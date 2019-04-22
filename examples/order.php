<?php
/**
 * Оформление заказа
 * Создаем/изменяем контакт, создание счета к контакту, наполнение строк счета, получение ссылки на оплату созданного счета
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// создаем контакт (если контакт с таким email существует, информация о нем будет обновлена)
$contact = $api->contact()->create([
    [
        'email' => 'example@mail.ru',
        'phone_number' => '+7999999999',
        'last_name' => 'Иванов',
        'name' => 'Семен',
        'middle_name' => 'Петрович',
        'id_partner' => 0,

        // полный список доступных полей смотрите в документации
    ]
]);

if (!is_object($contact)) {
    echo 'Ошибка при создании контакта: ' . $contact;
}

$idContact = $contact->id_contact;

// создаем счет для этого контакта
$invoice = $api->invoice()->create([
    [
        'id_contact' => $idContact, // ID контакта
        'last_name' => $contact->last_name, // фамилия на момент покупки
        'name' => $contact->name, // имя на момент покупки
        'middle_name' => $contact->middle_name, // отчество на момент покупки
        'email' => $contact->email, // email на момент покупки
        'id_partner' => $contact->id_partner, // ID партнера
        'account_sum' => 1340, // сумма счета. должна совпадать с суммой всех строк счета, включая доставку

        // полный список доступных полей смотрите в документации
    ]
]);

if (!is_object($invoice)) {
    echo 'Ошибка при создании счета: ' . $invoice;
}

$idInvoice = $invoice->id_account;

// создаем строки счета
$invoiceLine = $api->invoiceLine()->create([
    [
        'goods' => 'Товар 1', // Название товара на момент покупки
        'id_goods' => 6, // ID товара в системе
        'price_full' => 1000, // цена без скидки
        'price' => 1000, // цена со скидкой
        'quantity' => 1, // количество
        'sum_price' => 1000, // сумма (количество * цена со скидкой)
        'id_account' => $idInvoice, // ID счета, к которому относится строка

        // полный список доступных полей смотрите в документации
    ],
    [
        'goods' => 'Товар 2',
        'id_goods' => 1,
        'price_full' => 400,
        'price' => 340,
        'quantity' => 1,
        'sum_price' => 340,
        'id_account' => $idInvoice,
    ],
]);

// ссылка на оплату находится в свойстве 'link_for_pay'
$paymentLink = $invoice->link_for_pay;

/*
переменная $invoice содержит объект созданного счета
stdClass Object
(
    [account_number] => 21620
    [id_cash_receipt] => 0
    [date_of_order] => 2019-04-03 14:37:23
    [date_of_payment] => 0000-00-00 00:00:00
    [id_payment_system] => 0
    [id_organization] => 0
    [id_account_status] => 1
    [id_employee_account_status_change] =>
    [purchase_number] => 0
    [id_discount_revision] => 0
    [deleted] => 0
    [id_currency] => 0
    [currency_exchange_rate] => 1.0000
    [id_partner] => 0
    [id_partner_advertising_channel] => 0
    [close_account] => 0
    [close_date] => 0000-00-00 00:00:00
    [sent_in_ecommerce] => 0
    [id_advertising_channel_page] => 0
    [id_delivery_region] => 0
    [id_delivery_region_method] => 0
    [goods_return] => 0
    [goods_return_date] => 0000-00-00 00:00:00
    [id_callcenter_request] => 0
    [ip_employee_deleted] =>
    [id_contact] => 66038
    [last_name] =>
    [name] =>
    [middle_name] =>
    [phone_number] =>
    [zip_code] =>
    [area] =>
    [city] =>
    [delivery_address] =>
    [barcode] =>
    [skype] =>
    [account_comment] =>
    [more_options] =>
    [advertising_channel_keyword] =>
    [advertising_channel_location] =>
    [advertising_channel_type_traffic] =>
    [id_employee_created] =>
    [ip_client] => 127.0.0.1
    [account_status_change_date] => 2019-04-03 14:37:23
    [service_data_array] => N;
    [id_account] => 22956
    [email] =>
    [id_country] =>
    [account_sum] =>
    [discount_code] =>
    [sent_emails] =>
    [id_employee_deleted] =>
    [deleted_date] =>
    [link_for_pay] => https://test.autoweboffice.ru/?r=ordering/cart/s2&id=22956&vc=1760928208
)
 */
