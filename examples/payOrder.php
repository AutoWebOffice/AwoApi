<?php
/*
 * Изменение статуса счета на оплачен
 */

include __DIR__ . '/../AwoApi.php';

$api = new AwoApi([
    'apiKeyRead' => '',
    'apiKeyWrite' => '',
    'subdomain' => '',
]);

// код счета 370225
$result = $api->invoice()->update(370225, [
    'id_account_status' => 5, // новый статус (5 = оплачен)
]);

if (is_object($result)) {
    // счет изменен.
    // в переменной $result находится объект с данными измененного счета
    /*
    stdClass Object
    (
        [id_account] => 370225
        [account_number] => 302
        [id_cash_receipt] => 0
        [last_name] => Иванов
        [name] => Семен
        [middle_name] => Петрович
        [email] => x@1340.ru
        [phone_number] =>
        [zip_code] =>
        [area] =>
        [city] =>
        [delivery_address] =>
        [barcode] =>
        [skype] =>
        [date_of_order] => 2019-04-03 11:36:58
        [date_of_payment] => 2019-04-03 12:01:51
        [ip_client] => 2.94.156.28
        [more_options] =>
        [id_country] => 0
        [id_payment_system] => 0
        [id_contact] => 217
        [id_organization] => 0
        [id_account_status] => 5
        [id_employee_account_status_change] =>
        [account_status_change_date] => 2019-04-03 12:01:51
        [purchase_number] => 0
        [id_discount_revision] => 0
        [deleted] => 0
        [account_sum] => 1340
        [id_currency] => 0
        [currency_exchange_rate] => 1.0000
        [id_partner] => 0
        [id_partner_advertising_channel] => 0
        [close_account] => 0
        [close_date] => 0000-00-00 00:00:00
        [account_comment] =>
        [sent_in_ecommerce] => 0
        [id_advertising_channel_page] => 0
        [advertising_channel_keyword] =>
        [advertising_channel_location] =>
        [advertising_channel_type_traffic] =>
        [discount_code] =>
        [id_delivery_region] => 0
        [id_delivery_region_method] => 0
        [goods_return] => 0
        [goods_return_date] => 0000-00-00 00:00:00
        [service_data_array] => N;
        [sent_emails] =>
        [id_callcenter_request] => 0
        [id_employee_created] => 0
        [id_employee_deleted] => 0
        [ip_employee_deleted] =>
        [deleted_date] => 0000-00-00 00:00:00
    )
    */
}