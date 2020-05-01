<form action="<?php echo $action; ?>" method="POST">

    <input type="hidden" name="PAY_ID" value="<?php echo $ap_merchant; ?>"/>
    <input type="hidden" name="ORDER_ID" value="<?php echo $ap_itemcode; ?>"/>
    <input type="hidden" name="RETURN_URL" value="<?php echo $return_url; ?>"/>
    <input type="hidden" name="CUST_EMAIL" value="<?php echo $ap_email; ?>"/>
    <input type="hidden" name="CUST_NAME" value="<?php echo $customer_name; ?>"/>
    <input type="hidden" name="CUST_STREET_ADDRESS1" value=""/>
    <input type="hidden" name="CUST_CITY" value=""/>
    <input type="hidden" name="CUST_STATE" value=""/>
    <input type="hidden" name="CUST_COUNTRY" value=""/>
    <input type="hidden" name="CUST_ZIP" value=""/>
    <input type="hidden" name="CUST_PHONE" value="<?php echo $telephone; ?>"/>
    <input type="hidden" name="CURRENCY_CODE" value="356"/>
    <input type="hidden" name="AMOUNT" value="<?php echo $ap_amount; ?>"/>
    <input type="hidden" name="PRODUCT_DESC" value="Demo Transaction"/>
    <input type="hidden" name="CUST_SHIP_STREET_ADDRESS1" value=""/>
    <input type="hidden" name="CUST_SHIP_CITY" value=""/>
    <input type="hidden" name="CUST_SHIP_STATE" value=""/>
    <input type="hidden" name="CUST_SHIP_COUNTRY" value=""/>
    <input type="hidden" name="CUST_SHIP_ZIP" value=""/>
    <input type="hidden" name="CUST_SHIP_PHONE" value=""/>
    <input type="hidden" name="CUST_SHIP_NAME" value=""/>
    <input type="hidden" name="TXNTYPE" value="SALE"/>
    <input type="hidden" name="HASH" value="<?php echo $hash; ?>"/>

    <div class="buttons">
        <div class="pull-right">
            <input type="submit" value="<?php echo $button_confirm; ?>" class="btn btn-primary"/>
        </div>
    </div>
</form>


 
