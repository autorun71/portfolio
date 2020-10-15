<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$postJson = file_get_contents("php://input");
$params = json_decode($postJson, 1);
$data['ID'] = base64_decode($params['ID']);
$data['TP'] = base64_decode($params['TP']);
$data['A2005'] = base64_decode($params['A2005']);
$result = [
    'HTML' => null
];
ob_start();
$APPLICATION->IncludeComponent(
    "imaginweb:catalog.popup.buy_one_click",
    'ozerki',
    Array(
        "CACHE_TIME" => $arParams['CACHE_TIME'],
        "CACHE_TYPE" => $arParams['CACHE_TYPE'],
        "IBLOCK_ID" => $arParams['IBLOCK_ID'],
        "ID" => $data['ID'],
        "A2005" => $data['A2005'],
        "TP" => $data['TP']
    )
);
$html = ob_get_clean();

$result['HTML'] = $html;
echo json_encode($result, JSON_UNESCAPED_UNICODE);
