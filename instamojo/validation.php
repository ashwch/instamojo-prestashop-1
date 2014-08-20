<?php
require_once(dirname(__FILE__).'/lib/Config.php');
require_once(dirname(__FILE__) . '/../../config/config.inc.php');
require_once(dirname(__FILE__) . '/instamojo.php');

$instamojo = new instamojo();
$payment_url = IM_Config::PAYMENT_BASE.$_GET["payment_id"]."?api_key=".IM_Config::API_KEY."&auth_token=".IM_Config::AUTH_TOKEN;
$payment_json = file_get_contents($payment_url);
$payment_details= json_decode($payment_json,true);
$is_success=$payment_details["success"];
$payment_custom_fields= $payment_details["payment"]["custom_fields"];
$txn_id=$payment_custom_fields[IM_Config::TXN_ID_NAME]["value"];
$cart_id = explode('||', $txn_id);
$total = (float) $payment_details["payment"]["amount"];

if($is_success == true) {
$instamojo->validateOrder($cart_id[0], _PS_OS_PAYMENT_, $total, $instamojo->displayName,$payment_details, $cart_id, null, false, null, null);
}
else {
$instamojo->validateOrder($cart_id[0], _PS_OS_ERROR_, $total, $instamojo->displayName, $payment_details, $cart_id, null, false, null, null);
}

$result = Db::getInstance()->getRow('SELECT * FROM ' . _DB_PREFIX_ . 'orders WHERE id_cart = ' . (int) $cart_id[0]);
Tools::redirectLink(__PS_BASE_URI__ . 'order-detail.php?id_order=' . $result['id_order']);
?>