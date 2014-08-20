<?php
if (!defined('_PS_VERSION_'))
    exit;

require_once(dirname(__FILE__).'/lib/Config.php');

class Instamojo extends PaymentModule {

public function __construct()
  {
    $this->name = 'instamojo';
    $this->tab = 'payments_gateways';
    $this->version = '0.1';
    $this->author = 'Ankit Daftery';
    $this->need_instance = 0;
    $this->currencies = true;
    $this->currencies_mode = 'radio';
    $this->ps_versions_compliancy = array('min' => '1.5', 'max' => '1.6');
    $this->bootstrap = true;
 
    parent::__construct();
    $this->page = basename(__FILE__, '.php'); 
    $this->displayName = $this->l('Instamojo');
    $this->description = $this->l('Accept Payments using Instamojo');
 
    $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');
 
    if (!Configuration::get('INSTAMOJO'))      
      $this->warning = $this->l('No name provided');
  }

public function install()
{

if (!parent::install() || !$this->registerHook('payment') || !$this->registerHook('paymentReturn') || !$this->registerHook('leftColumn') ||    !$this->registerHook('header') ||    !Configuration::updateValue('INSTAMOJO', 'instant payments'))
   return false;
 
  return true;
}

public function uninstall()
{
  if (!parent::uninstall() ||
    !Configuration::deleteByName('MYMODULE_NAME')
  )
    return false;
 
  return true;
}

public function getContent()
{
    $output = null;
 
    if (Tools::isSubmit('submit'.$this->name))
    {
        $my_module_name = strval(Tools::getValue('INSTAMOJO'));
        if (!$my_module_name
          || empty($my_module_name)
          || !Validate::isGenericName($my_module_name))
            $output .= $this->displayError($this->l('Invalid Configuration value'));
        else
        {
            Configuration::updateValue('INSTAMOJO', $my_module_name);
            $output .= $this->displayConfirmation($this->l('Settings updated'));
        }
    }
    return $this->display(__FILE__, '/views/templates/admin/configure_instamojo.tpl');
}

public function hookdisplayPayment($params) {
        
        if (!$this->active)
            return;
        //!$cart->OrderExists();
        $customer = new Customer($params['cart']->id_customer);
        $email_address = $customer->email;
        $currency = trim($this->getCurrency()->iso_code);

        $Amount = $params['cart']->getOrderTotal(true, 3) * 100;
        $cartId = $params['cart']->id;
        
        $address = new Address($params['cart']->id_address_invoice);

        $products = $params['cart']->getProducts();
        $quantity = '';
        $product_name = '';
        $product_count = count($products);
        for ($i = 0; $i < $product_count; $i++) {
            $quantity .= $products[$i]['cart_quantity'] . ',';
            $product_name .= $products[$i]['name'] . ',';
        }

        $product_name = (Tools::strlen($product_name) > 100) ? Tools::substr($product_name, 0, 100) : $product_name;
        $complete_address = $address->address1 . ' ' . $address->address2;
        $complete_address = (Tools::strlen($complete_address) > 100) ? Tools::substr($complete_address, 0, 100) : $complete_address;
        $module_version = (Tools::strlen($module_version) > 20) ? Tools::substr($module_version, 0, 20) : $module_version;

        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' && $_SERVER['HTTPS'] != 'OFF') {
            //TODO:: callback url, validate
            $redirect_url = 'https://' . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/instamojo/validation.php';
        } else {
            $redirect_url = 'http://' . htmlspecialchars($_SERVER['HTTP_HOST'], ENT_COMPAT, 'UTF-8') . __PS_BASE_URI__ . 'modules/instamojo/validation.php';
        }
$imname = $address->firstname . ' ' . $address->lastname;
$imemail = $email_address;
$imphone = $address->phone_mobile;
$imamount = $Amount;
$imtid = $cartId . '||' . date('his');

$this->smarty->assign('imname', $imname);
$this->smarty->assign('imemail', $imemail);
$this->smarty->assign('imphone', $imphone);
$this->smarty->assign('imkey',$imkey);
$this->smarty->assign('imtid',$imtid);
$this->smarty->assign('imcustom',IM_Config::TXN_ID_NAME);
$this->smarty->assign('imamount',$params['cart']->getOrderTotal(true, 3));

return $this->display(__FILE__, '/views/templates/front/instamojo.tpl');
    }


public function validateOrder($id_cart, $id_order_state, $amount_paid, $payment_method = 'Unknown', $response_message = null, $extra_vars = array(), $currency_special = null, $dont_touch_amount = false, $secure_key = false, Shop $shop = null) {
        if (!$this->active)
            return;
        parent::validateOrder((int) $id_cart, (int) $id_order_state, (float) $amount_paid, $payment_method, $response_message, $extra_vars, $currency_special, true, false, null);
    }

}

?>
