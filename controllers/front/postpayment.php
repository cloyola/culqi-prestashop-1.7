<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

include_once dirname(__FILE__, 3) . '/libraries/culqi-php/lib/culqi.php';
include_once dirname(__FILE__, 3) . '/culqi.php';

class CulqiPostpaymentModuleFrontController extends ModuleFrontController
{	

    public function initContent()
    {
        parent::initContent();
        $this->ajax = false;
        $chargeid = Tools::getValue("chargeid");
        if($chargeid!=null and !empty($chargeid) and !is_null($chargeid) and $chargeid != ''){
        
            $cart = $this->context->cart;
            $customer = new Customer($cart->id_customer);
            $this->module->validateOrder((int)$cart->id, Configuration::get('CULQI_STATE_OK'), (float)$cart->getordertotal(true), 'Culqi', null, array(), (int)$cart->id_currency, false, $customer->secure_key);

            $id_order = Order::getOrderByCartId($this->context->cart->id);
            
            $order = new Order($id_order);
            $order_payment_collection = $order->getOrderPaymentCollection();

            $order_payment = $order_payment_collection[0];
            $order_payment->card_number = Tools::getValue("card_number");
            $order_payment->card_brand = Tools::getValue("card_brand");
            $order_payment->transaction_id = $chargeid;
            $order_payment->update();
            $culqiPretashop =  new Culqi();
            $infoCheckout = $culqiPretashop->getCulqiInfoCheckout();
            $enviroment_cart = $infoCheckout['enviroment_backend'];
            $culqi = new Culqi\Culqi(array('api_key' => $infoCheckout['llave_secreta'] ));
            $args_charge = array(
                'enviroment' => $enviroment_cart,
                'metadata' => ["order_id" => $id_order, "sponsor" => "prestashop"],
            );

            try{
                $culqi_charge = $culqi->Charges->update( $chargeid, $args_charge );
            }catch (Exception $e){
                echo '<script type="text/javascript">console.log("Error en el update de cargo!"); </script>';
            }

            Tools::redirect('index.php?controller=order-confirmation&id_cart=' . (int)$cart->id . '&id_module=' . (int)$this->module->id . '&id_order=' . $this->module->currentOrder . '&key=' . $customer->secure_key);
        }
    }

}