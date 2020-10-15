<?php

use Bitrix\Main\Loader;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var CMain $APPLICATION
 * @var $USER CUser
 */

use \Bitrix\Main\Web\Json as Json;

class CatalogElementBuyOneClickLink extends \CBitrixComponent
{

    public $arParams;
    public $arResult;

    private function getElement()
    {
        if (empty($this->arParams['ID']) || empty($this->arParams['IBLOCK_ID'])) {
            return [];
        }
        if (!empty($this->arParams['ID']) && !empty($this->arParams['A2005']) && $this->arParams['TP']) {
            return [
                "ID" => base64_encode($this->arParams['ID']),
                "A2005" => base64_encode($this->arParams['A2005']),
                "TP" => base64_encode($this->arParams['TP'])
            ];
        }
        $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PROPERTY_KOD_A2005", "PROPERTY_*");
        $arFilter = Array("IBLOCK_ID" => $this->arParams['IBLOCK_ID'], "ID" => $this->arParams['ID'], "ACTIVE" => "Y");
        $res = \CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 1), $arSelect);
        $el = $res->Fetch();
        $el['TP'] = $this->arParams['TP'];
        if (empty($this->arParams['TP'])) {
            list($itemStatus, $itemData) = array_values(OzerkiShopHelper::getItem($el['ID'], 0, true));
            $currentTp = $itemStatus != OzerkiShopHelper::ITEM_STATUS_NONE ? $itemData : [];
            $el['TP'] = $currentTp['DATA_TP'];
        }
        return [
            "ID" => base64_encode($el['ID']),
            "A2005" => base64_encode($el['PROPERTY_KOD_A2005_VALUE']),
            "TP" => base64_encode($el['TP'])
        ];
    }

    public function executeComponent()
    {

        $this->arResult['ITEM'] = $this->getElement();
        $this->includeComponentTemplate();
    }
}