<?php
/**
 * @var $params
 * @var $result
 */
?>
<div class="success-one_click">
    <div class="order_num">Номер вашего заказа <b><?=$params['ORDER_ID']?></b></div>
    <div class="order-success-one_click">
        <span>Ваш заказ забронирован в аптеке, по адресу</span>
        <span><?=$params['STORE']['NAME']?></span>
    </div>
    <div class="wait_sms_text">Ждите СМС о готовности заказа</div>
</div>
