<?php


class OneClickOrderBase
{
    protected $params;
    private $basket;
    private $order;
    private $product;
    private $productTpData;
    protected $userID;
    protected $siteID;
    private $catalogProduct;
    private $pharmacy;

    public function __construct($params)
    {
        \CModule::IncludeModule('sale');
        \CModule::IncludeModule('iblock');

        $this->params = $params;
        $this->prepareParams();
    }

    protected function prepareParams()
    {

        $this->siteID = 'ho';
        $this->userID = $this->params['USER_INFO'] ? $this->params['USER_INFO']['ID'] : \CSaleBasket::GetBasketUserID();
        $this->basketCreate();
        $this->orderCreate();
        $this->setProduct();
        $this->setCatalogProduct();
        $this->setTpData();
        $this->setSelectedPharmacy();
    }

    private function basketCreate()
    {
        $this->basket = Bitrix\Sale\Basket::loadItemsForFUser($this->userID, $this->siteID);
    }

    protected function getBasket()
    {
        return $this->basket;
    }

    private function orderCreate()
    {
        global $USER;
        $this->order = \Bitrix\Sale\Order::create(SITE_ID, $USER->isAuthorized() ? $USER->GetID() : $this->userID);
    }

    protected function getOrder()
    {
        return $this->order;
    }

    private function setProduct()
    {
        $this->product = array_shift(ProductInfoTable::get(array(
            'filter' => array('UF_PRODUCT_ID' => $this->params['PRODUCT'])
        )));
    }
    private function setCatalogProduct()
    {
        $this->catalogProduct = \CCatalogProduct::GetByIDEx($this->params['PRODUCT']);


    }

    protected function getProduct()
    {
        return $this->product;
    }

    protected function getCatalogProduct()
    {
        return $this->catalogProduct;
    }

    private function setTpData()
    {

        $this->productTpData = OzerkiShopHelper::getCurrentTpData($this->product, $this->params['STORE']['XML_ID']);

    }

    protected function getTpData()
    {
        return $this->productTpData;
    }

    protected function getCurrentTp()
    {
        $currentTp = $this->getTpData()['TPS'];
        return array_shift($currentTp);
    }

    private function setSelectedPharmacy()
    {

        $pharmacy = OzerkiShopHelper::getSelectedPharmacy();

        $this->pharmacy['PHARMACY'] = $pharmacy ?: $this->params['STORE'];
        $this->pharmacy['STOCK'] = $this->params['STOCK_STORE'] ?: $this->params['STORE'];
    }
    
    protected function getSelectedPharmacy($getStock=false)
    {
        if ($getStock){
            return $this->pharmacy['STOCK'];
        }
        return $this->pharmacy['PHARMACY'];

    }
}

//$basket = Bitrix\Sale\Basket::loadItemsForFUser($userBasketId, $siteID);
//$basket = \Bitrix\Sale\Basket::create($siteID);
//$basket->setFUserId($userBasketId);

