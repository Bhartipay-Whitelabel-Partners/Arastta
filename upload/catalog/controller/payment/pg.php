<?php
/**
 * @package     Arastta eCommerce
 * @copyright   2015-2017 Arastta Association. All rights reserved.
 * @copyright   See CREDITS.txt for credits and other copyright notices.
 * @license     GNU GPL version 3; see LICENSE.txt
 * @link        https://arastta.org
 */

class ControllerPaymentPg extends Controller
{
        public function generateHash($data)
    {
        $post_data=array();
        //print_r($data);echo "<br>";
        $secret_key=$data['ap_secret_key'];

 
//real return url==http://localhost/my_projects/Arastta/index.php?route=checkout/success
    $post_data=array();
     $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
     //print_r($order_info);exit;
    $return_url_for_store=$order_info['store_url'];
    $post_data['PAY_ID'] = $data['ap_merchant'];
    $post_data['ORDER_ID'] = $data['ap_itemcode'];
    $post_data['RETURN_URL'] ="$return_url_for_store" .'index.php?route=payment/pg/callback';
    $post_data['CUST_EMAIL'] =$data['ap_email'];
    $post_data['CUST_NAME'] = $data['customer_name'];
    $post_data['CUST_STREET_ADDRESS1'] = '';
    $post_data['CUST_CITY'] = '';
    $post_data['CUST_STATE'] = '';
    $post_data['CUST_COUNTRY']= '';
    $post_data['CUST_ZIP']='';
    $post_data['CUST_PHONE']=$order_info['telephone'];
    $post_data['CURRENCY_CODE']= 356;
    $post_data['AMOUNT']=$data['ap_amount'];
    $post_data['PRODUCT_DESC']='Demo Transaction';
    $post_data['CUST_SHIP_STREET_ADDRESS1']='';
    $post_data['CUST_SHIP_CITY']='';
    $post_data['CUST_SHIP_STATE']=''; 
    $post_data['CUST_SHIP_COUNTRY']='';
    $post_data['CUST_SHIP_ZIP']='';
    $post_data['CUST_SHIP_PHONE']='';
    $post_data['CUST_SHIP_NAME']='';
    $post_data['TXNTYPE']='SALE';

   ksort($post_data);
// print_r($post_data);exit;
    $all = '';
        foreach ($post_data as $name => $value) {
            $all .= $name."=".$value."~";
        }
 
        $all = substr($all, 0, -1);
        $all.=$secret_key;

         return strtoupper(hash('sha256', $all));      
    }
    public function index()
    {
        $data['button_confirm'] = $this->language->get('button_confirm');

        $this->load->model('checkout/order');

        $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);
        $data['ap_email']     = $order_info['email'];
        $data['customer_name'] = $order_info['payment_firstname']." ".$order_info['payment_lastname'];
        $data['action'] = 'https://uat.pg.com/crm/jsp/paymentrequest';
        //$data['action'] = 'https://uat.pg.com/crm/jsp/paymentrequest';
        $data['ap_merchant']     = $this->config->get('pg_merchant');
        $data['ap_secret_key']     = $this->config->get('pg_security');
        
        $data['ap_amount']       = $this->currency->format($order_info['total'], $order_info['currency_code'], $order_info['currency_value'], false);
        //echo $data['ap_amount'] ;
        $data['ap_amount'] =floor($data['ap_amount']*100);

        $data['ap_currency']     = $order_info['currency_code'];
        $data['ap_purchasetype'] = 'Item';
        $data['ap_itemname']     = $this->config->get('config_name') . ' - #' . $this->session->data['order_id'];
        $data['ap_itemcode']     = $this->session->data['order_id'];
        $data['ap_returnurl']    = $this->url->link('checkout/success');
        $data['ap_cancelurl']    = $this->url->link('checkout/checkout', '', 'SSL');
        $data['telephone']    = $order_info['telephone'];
       
        $return_url_for_store=$order_info['store_url'];
         $data['return_url']    = "$return_url_for_store".'index.php?route=payment/pg/callback';


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pg.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/payment/pg.tpl', $data);
        } else {
            
               $data['hash'] = $this->generateHash($data);
               $post_data['HASH'] = $this->generateHash($data);
            return $this->load->view('default/template/payment/pg.tpl', $data);
        }
    }



    public function callback()
    {
        if ($_POST['STATUS']=='Cancelled') {
            $url=$this->url->link('checkout/');
            $this->load->model('checkout/order');
            //$this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('pg_order_status_id'),true);
            header("Location: $url");
            die();

        }


       else if ($_POST['STATUS']=='Captured') {
            $this->load->model('checkout/order');
            $this->model_checkout_order->addOrderHistory($this->session->data['order_id'], $this->config->get('pg_order_status_id'),true);
            $url=$this->url->link('checkout/success');
            header("Location: $url");
            die();

        }

    }
}
