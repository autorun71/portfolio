<?php

include_once 'OneClickOrderBase.php';

class OneClickOrder extends OneClickOrderBase
{
    private $basketProps;
    private $basketItem;
    private $bonuses;
    private $orderId;
    private $discountPrice;
    private $countBonuses;
    private $basketPropsCollection;

    public function __construct($params)
    {
        parent::__construct($params);

    }

    protected function prepareParams()
    {

        parent::prepareParams();

        $this->setBasketProps();
        $this->createBasketItem();
    }

    public function save()
    {
        $this->setBonuses();
        $this->setBasketBonusesProps();
        //

        $this->basketPropsCollection->setProperty($this->basketProps);
        $this->basketPropsCollection->save();
        //
        $this->getOrder()->setBasket($this->getBasket());
        $this->setOrder();
        $this->getOrder()->doFinalAction(true);

        $this->orderId = $this->getOrder()->save()->getId();
        $this->setManzanaCheque();

//        return false;
        return $this->getOrder();

    }

    public function setBasketProps()
    {
        $pharmacy = $this->getSelectedPharmacy($this->params['USE_STOCK'] == 1 ? true : false);


        $arProps[] = array(
            'NAME' => 'ID города торгового предложения',
            'CODE' => 'CITY',
            'VALUE' => $this->getTpData()['CITY'],
            'SORT' => 1
        );

        $arProps[] = array(
            'NAME' => 'XML_ID торгового предложения',
            'CODE' => 'OFFER_XML_ID',
            'VALUE' => $this->getCurrentTp()['ID'],
            'SORT' => 2
        );

        $arProps[] = array(
            'NAME' => 'Склад',
            'CODE' => 'STORE_ID',
            'VALUE' => $pharmacy['XML_ID'],
            'SORT' => 3
        );

        $this->basketProps = $arProps;
    }

    private function createBasketItem()
    {
        $this->clearBasket();

        $basketItem = $this->getBasket()->createItem('catalog', $this->getProduct()['UF_PRODUCT_ID']);
        $basketItem->setField('PRODUCT_ID', $this->getProduct()['UF_PRODUCT_ID']);
        $basketItem->setField('NAME', $this->getProduct()['UF_PRODUCT_NAME']);
        $basketItem->setField('CURRENCY', 'RUR');
        $basketItem->setField('QUANTITY', $this->params['COUNT']);
        $basketItem->setField('PRODUCT_XML_ID', $this->getCurrentTp()['ID']);
        $basketItem->setField('LID', $this->siteID);
        $basketItem->setField('PRICE', $this->getCurrentTp()['PRICE']);
        $basketItem->setField('CUSTOM_PRICE', 'Y');
//$basketItem->setField('PRODUCT_PROVIDER_CLASS', 'CCatalogProductProviderCustom');
        $basketItem->save();
        $this->basketItem = $basketItem;


        $basketPropertyCollection = $basketItem->getPropertyCollection();
        $this->basketPropsCollection = $basketPropertyCollection;



    }

    private function clearBasket()
    {
        $basketItems = $this->getBasket()->getBasketItems();
        foreach ($basketItems as $basketItem) {
            $basketItem->delete();
        }
    }

    private function setOrder()
    {
        $this->getOrder()->setPersonTypeId(1);
        $this->setOrderPayment();
        $this->setOrderShipment();
        $this->setOrderProperties();
    }

    private function setOrderPayment()
    {
        $paymentCollection = $this->getOrder()->getPaymentCollection();
        $payment = $paymentCollection->createItem();
        $paySystemService = \Bitrix\Sale\PaySystem\Manager::getObjectById(1);
        $payment->setFields([
            'PAY_SYSTEM_ID' => $paySystemService->getField("PAY_SYSTEM_ID"),
            'PAY_SYSTEM_NAME' => $paySystemService->getField("NAME"),
        ]);
    }

    private function setOrderShipment()
    {
        $shipmentCollection = $this->getOrder()->getShipmentCollection();
        $shipment = $shipmentCollection->createItem();
        $service = \Bitrix\Sale\Delivery\Services\Manager::getById(\Bitrix\Sale\Delivery\Services\EmptyDeliveryService::getEmptyDeliveryServiceId());
        $shipment->setFields(array(
            'DELIVERY_ID' => $service['ID'],
            'DELIVERY_NAME' => $service['NAME'],
        ));
        $shipmentItemCollection = $shipment->getShipmentItemCollection();
        $shipmentItem = $shipmentItemCollection->createItem($this->basketItem);
        $shipmentItem->setQuantity($this->basketItem->getQuantity());

    }

    private function setBonuses()
    {
        $a2005 = $this->getProduct()['UF_A2005'];
        $basket_products[$a2005] = $this->basketItem->getFields();
        $basket_products[$a2005]['PROPERTY_KOD_A2005_VALUE'] = $a2005;
        $this->bonuses = OzerkiShopHelper::getChargedBonuses($this->params['USER_INFO']['UF_CARD_NUMBER'], $basket_products);

        if (!empty($this->bonuses['DISCOUNT_PRICE'])){
            $this->discountPrice = $this->bonuses['DISCOUNT_PRICE'];
        }
        if (!empty($this->bonuses['BONUSES'])){
            $this->countBonuses = $this->bonuses['BONUSES'];
        }
        unset($basket_products[$a2005]['PROPERTY_KOD_A2005_VALUE']);
    }

    private function setOrderProperties()
    {
        $propertyCollection = $this->getOrder()->getPropertyCollection();

        $phone = $propertyCollection->getItemByOrderPropertyId(OzerkiShopHelper::getOrderPropertyIdByCode('PHONE'));
        $phone->setValue($this->params['PHONE']);

        if (!empty($this->params['USER_INFO'])){
            if ($this->params['USER_INFO']['EMAIL']){
                $email = $propertyCollection->getItemByOrderPropertyId(OzerkiShopHelper::getOrderPropertyIdByCode('EMAIL'));
                $email->setValue($this->params['USER_INFO']['EMAIL']);
            }
            if ($this->params['USER_INFO']['NAME']){
//                $name = $propertyCollection->getItemByOrderPropertyId(OzerkiShopHelper::getOrderPropertyIdByCode('NAME'));
//                $name->setValue($this->params['USER_INFO']['NAME']);
            }
            if (!empty($this->params['USER_INFO']['UF_CARD_NUMBER'])){
                $cardZoz = $propertyCollection->getItemByOrderPropertyId(OzerkiShopHelper::getOrderPropertyIdByCode('CARD_NUMBER'));
                $cardZoz->setValue($this->params['USER_INFO']['UF_CARD_NUMBER']);
            }



        }



        $pharmacy = $propertyCollection->getItemByOrderPropertyId(OzerkiShopHelper::getOrderPropertyIdByCode('PHARMACY_ID'));
        $pharmacy->setValue($this->getSelectedPharmacy()['XML_ID']);

        if ($this->bonuses['RESPONSE']->ProcessRequestResult->ChequeResponse->WriteoffBonus > 0) {
            $bonuses = $propertyCollection->getItemByOrderPropertyId(OzerkiShopHelper::getOrderPropertyIdByCode('BONUSES'));
            $bonuses->setValue($this->bonuses['RESPONSE']->ProcessRequestResult->ChequeResponse->WriteoffBonus);
        }
    }

    private function setManzanaCheque()
    {
        if ($this->orderId > 0){
            if (isset($_SESSION['LAST_SOFT_CHEQUE']) && strlen($_SESSION['LAST_SOFT_CHEQUE']) > 0 || isset($_SESSION['LAST_SOFT_CHEQUE_DROGERIE']) && strlen($_SESSION['LAST_SOFT_CHEQUE_DROGERIE']) > 0) {
                $result = Imaginweb\Models\Db\Manzana\OrderSoftChequeTable::add(array(
                    'ORDER_ID' => $this->orderId,
                    'SOFT_CHEQUE' => $_SESSION['LAST_SOFT_CHEQUE'],
                    'SOFT_CHEQUE_DROGERIE' => $_SESSION['LAST_SOFT_CHEQUE_DROGERIE']
                ));

                if ($result->isSuccess()) {
                    unset($_SESSION['LAST_SOFT_CHEQUE']);
                    unset($_SESSION['LAST_SOFT_CHEQUE_DROGERIE']);
                }
            }
        }

    }

    private function setBasketBonusesProps()
    {
        $arProps = $this->basketProps;


        if (!empty($this->discountPrice)) {
            $dPrice = $this->discountPrice;
            $arProps[] = array('NAME' => 'Цена со скидкой', 'CODE' => 'DISCOUNT_PRICE', 'VALUE' => array_shift($dPrice), 'SORT' => 50);
        }
        if (!empty($this->countBonuses)) {
            $cBonuses = $this->countBonuses;
            $arProps[] = array('NAME' => 'Баллы', 'CODE' => 'BONUSES', 'VALUE' => array_shift($cBonuses), 'SORT' => 4);
        }


        $this->basketProps = $arProps;
    }

}
