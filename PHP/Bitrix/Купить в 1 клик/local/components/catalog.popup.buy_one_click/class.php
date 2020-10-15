<?php
use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CMain $APPLICATION
 * @var $USER CUser
 */
use \Bitrix\Main\Web\Json as Json;

class CatalogPopupBuyOneClick extends \CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        global $APPLICATION;
        $this->arResult = array();
        return $arParams;
    }

    protected function prepareAction()
    {
        $action = $this->request->get('action');
        return $action;
    }

    protected function doAction($action)
    {
        if(is_callable(array($this, $action.'Action')))
        {
            call_user_func(array($this, $action.'Action'));
        }
    }

    protected function showAjaxAnswer($result)
    {
        global $APPLICATION;
        $APPLICATION->RestartBuffer();
        header('Content-Type: application/json');
        echo Json::encode($result);
        CMain::FinalActions();
        die();
    }

    protected function getDeliveryInfoAction()
    {

    }

    public function executeComponent()
    {
        $action = $this->prepareAction();
        $this->doAction($action);

        $this->getElement();
        $this->includeComponentTemplate();
    }

    private function getElement()
    {
        $item = [];



        $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PICTURE", "PREVIEW_PICTURE", "IBLOCK_SECTION_ID", "PROPERTY_BRAND", "UF_OFFERS");
        $arFilter = Array("IBLOCK_ID"=>IntVal(IBLOCK_CATALOG_ID), "ID" => $this->arParams['ID'] ?: false);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
        if($ob = $res->GetNextElement()) {
            $item = $ob->GetFields();
            $sectionResult = CIBlockSection::GetList(Array("SORT"=>"ASC"), ["IBLOCK_ID"=>IntVal(IBLOCK_CATALOG_ID), "ID" => $item["IBLOCK_SECTION_ID"] ?: false], false, ['ID', 'NAME']);
            if($section = $sectionResult->GetNext()){
                $item['SECTION'] = $section;
            }

            $brandResult = CIBlockElement::GetList(Array(), ["IBLOCK_ID" => IBLOCK_BRANDS_ID, "ID" => $item['PROPERTY_BRAND_VALUE'] ?: false], false, Array("nPageSize"=>1), ['ID', 'NAME']);
            if($brand = $brandResult->GetNext()){
                $item['BRAND'] = $brand;
            }

            $picture = $item['DETAIL_PICTURE'] ?: $item['PREVIEW_PICTURE'] ?: false;
            if (!empty($picture)){
                $picture = CFile::getPath($picture);
            }else{
                $picture = '/local/templates/agima/backend/img/base/camera.svg';
            }
            $item['IMG'] = $picture;
            $item['STORE'] = $item['STOCK_STORE'] = OzerkiShopHelper::getStockMain();
            $item['OFFER_STOCK'] = OzerkiShopHelper::getItemInPharmacy($this->arParams['ID'], $item['STOCK_STORE']);
            $item['OFFER'] = $this->getOffer();
            if (empty($item['OFFER'])){
                $item['OFFER'] = $item['OFFER_STOCK'];
                $item['OFFER_STOCK'] = [];
            }

            $minPrice = false;
            $priceStock = false;
            if (!empty($item['OFFER'])){
                $item['COUNT_PHARMACY'] =  $item['OFFER']['COUNT'];
                $item['COUNT'] =  $item['OFFER']['COUNT'] + (!empty($item['OFFER_STOCK']) ? $item['OFFER_STOCK']['COUNT'] : 0);
                $item['STORE'] = $item['OFFER']['PHARMACY'];

                foreach ($item['OFFER']['TPS'] as $tps){
                    $price = $tps['PRICE'];
                    if (empty($minPrice) || $price < $minPrice){
                        $minPrice = $price;
                    }
                }
                foreach ($item['OFFER_STOCK']['TPS'] as $tps){
                    $priceStock = $tps['PRICE'];
                    break;
                }
            }
            if (!empty($item['STORE'])){
                $item['STORE_INFO'] = $this->getPharmacyInfo($item['STORE']);
                if (!empty($item['STORE_INFO']['PROPERTY']['METRO'])){
                    $item['STORE_INFO']['METRO_INFO'] = $this->getMetro($item['STORE_INFO']['PROPERTY']['METRO']);
                }
            }
            $item['PRICE'] = $minPrice ?: 0;
            $item['PRICE_STOCK'] = $priceStock ?: 0;
            $item['FORMAT_PRICE'] = $this->formatPrice($item['PRICE']);
//            $item['STORE'] = $offerId;

        }

        $this->arResult['ITEM'] = $item;




    }

    private function getOffer()
    {
        $this->arResult['PARAMS'] = $this->arParams;
        $arProducts = ProductInfoTable::get(array(
            'filter'=>array('UF_PRODUCT_ID' => $this->arParams['ID']), 'select' => array('UF_OFFERS')
        ));

        return OzerkiShopHelper::getCurrentTpData(array_shift($arProducts));
    }

    private function formatPrice($price)
    {
        $arPrice = explode('.', $price);
        if (empty($arPrice[1])){
            $arPrice[1] = '00';
        }
        if (strlen($arPrice[1]) == 1){
            $arPrice[1] = '0'. (string)$arPrice[1];
        }
        return $arPrice;
    }

    public function getPharmacyInfo($pharmacyXmlId){
        $result = [];
        if(!$pharmacyXmlId){
            return $result;
        }

        $arFilter = array(
            'IBLOCK_ID' => IBLOCK_ID_PHARMACY,
            'ACTIVE' => 'Y',
            'XML_ID' => $pharmacyXmlId ?: false
        );

        $dbElem = \CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            false,
            array('ID', 'XML_ID', 'IBLOCK_ID', 'PROPERTY_ADDRESS_STRUCTURE')
        );

        if ($obElem = $dbElem->GetNextElement()) {
            $result = $obElem->GetFields();
            $props = $obElem->GetProperties();
            $result['PROPERTY'] = array_map(function ($item){
                return $item['VALUE'];
            }, $props);
            $result['address'] = json_decode($result['PROPERTY_ADDRESS_STRUCTURE_VALUE']['TEXT'], true);
        }

        return $result;
    }

    private function getMetro($METRO)
    {
        $result = [];
        if(!$METRO){
            return $result;
        }

        $arFilter = array(
            'IBLOCK_ID' => IBLOCK_ID_METRO,
            'ACTIVE' => 'Y',
            'ID' => $METRO
        );

        $dbElem = \CIBlockElement::GetList(
            array(),
            $arFilter,
            false,
            false,
            array('ID', 'XML_ID', 'NAME', 'IBLOCK_ID', 'PROPERTY_ADDRESS_STRUCTURE')
        );

        if ($obElem = $dbElem->GetNextElement()) {
            $result = $obElem->GetFields();

        }

        return $result;
    }
}