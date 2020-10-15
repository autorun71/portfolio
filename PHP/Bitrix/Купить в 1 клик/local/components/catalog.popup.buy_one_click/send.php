<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
include_once 'OneClickOrder.php';
$postJson = file_get_contents("php://input");
$postParams = json_decode($postJson, 1);
$params = $postParams;
$result = [
    'PARAMS' => $params,
    'status' => false,
    'error' => null
];
CModule::IncludeModule('sale');
CModule::IncludeModule('order');
CModule::IncludeModule('iblock');
CModule::IncludeModule('catalog');
$user = $params['USER_INFO'] = getUserByNumber($params['PHONE']);

if (!empty($user)){
    $params['USER_EMAIL'] = $user['EMAIL'];
    $params['USER_FIO'] = $user['NAME'] . ($user['SECOND_NAME'] ? ' ' . $user['SECOND_NAME'] : '' ) . ($user['LAST_NAME'] ? ' ' . $user['LAST_NAME'] : '' );
}
$params['PHONE'] = str_replace(['(', ')', ' ', '_', '-'], '', $params['PHONE']);
$result['fields'] = array_keys($postParams);

$result['error'] = filterRequiredFields($params);

$property_enums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"),
    Array("IBLOCK_ID" => IBLOCK_BUY_ONE_CLICK, "CODE" => "USE_DARKSTORE"));
$useDarkStoreProps = [
    'Y' => null,
    'N' => null,
];
while ($enum_fields = $property_enums->GetNext()) {
    switch ($enum_fields['XML_ID']) {
        case 'Y':
            $useDarkStoreProps['Y'] = $enum_fields['ID'];
            break;
        case 'N':
            $useDarkStoreProps['N'] = $enum_fields['ID'];
            break;
    }
}
// STORE

$params['STORE'] = getStore($params['STORE']);
$params['STOCK_STORE'] = getStore($params['STOCK_STORE']);

$dateTime = date('d.m.Y H:i');
$el = new CIBlockElement;
//$APPLICATION->userId()
$PROP = array(
    "USER_FIO" => 'test',
    "PHONE" => $params['PHONE'],
    "PRODUCT" => $params['PRODUCT'],
    "COUNT" => $params['COUNT'],
    "PRICE" => $params['PRICE'],
    "STORE" => $params['STORE']['ID'],
    "DARK_STORE" => $params['STOCK_STORE']['ID'],
    "DATETIME" => $dateTime,
    "USE_DARKSTORE" => [
        "ID" => $useDarkStoreProps[$params['USE_STOCK'] == 1 ? 'Y' : 'N']
    ],
);



//$arLoadProductArray = Array(
//    'MODIFIED_BY' => $GLOBALS['USER']->GetID(), // элемент изменен текущим пользователем
//    'IBLOCK_SECTION_ID' => false, // элемент лежит в корне раздела
//    'IBLOCK_ID' => IBLOCK_BUY_ONE_CLICK,
//    'PROPERTY_VALUES' => $PROP,
//    'NAME' => 'Новая заявка от ' . $dateTime,
//    'ACTIVE' => 'Y', // активен
//);
$active = true;

if (empty($result['error']) && $active) {
    $order = new OneClickOrder($params);
    $params['ORDER_ID'] = $order->save()->getId();
    if (!empty($params['ORDER_ID']) && $params['ORDER_ID'] > 0) {
        ob_start();
        include 'success.php';
        $result['html'] = ob_get_clean();
        $result['headerText'] = 'Спасибо за бронирование!';
        $result['status'] = true;
        sendOrderMessage($params);
    } else {
        $result['status'] = false;
        $result['error'][] = $el->LAST_ERROR;;
    }
}


echo json_encode($result, JSON_UNESCAPED_UNICODE);

function getStore($xmlID)
{
    $arSelect = Array("ID", "NAME", "XML_ID");
    $arFilter = Array(
        "IBLOCK_ID" => IntVal(IBLOCK_CITIES_ID),
        "EXTERNAL_ID" => $xmlID ?: false,
        "ACTIVE" => "Y"
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
    $store = false;
    if ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $store = $arFields;
    }

    return $store;
}

function filterRequiredFields($params)
{

    $requiredFields = [
        "COUNT" => [
            'message' => 'Количество товаров',
            'length' => '1',
            'min' => 1
        ],
        "PHONE" => [
            'message' => 'Номер телефона',
            'length' => '12',
        ],

        "PRICE" => 'Цена',
        "PRODUCT" => 'ID товара',
        "STORE" => 'Аптека',
    ];
    $errors = null;
    foreach ($requiredFields as $field => $message) {

        $thisError = false;
        $fieldName = is_array($message) ? $message['message'] : $message;
        if (empty($params[$field])) {
            $errors[] = [
                'field' => $field,
                'message' => 'Поле <b>"' . $fieldName . '"</b> заполнено некорректно!'
            ];
            $thisError = true;
        }
        if (is_array($message)) {
            if (!empty($message['min']) && $params[$field] < $message['min']) {
                if ($thisError) {
                    $thisError = false;
                    array_pop($errors);
                }
                $errors[] = [
                    'field' => $field,
                    'message' => 'Некорректное значение поля <b>"' . $fieldName . '"</b>'
                ];

            }

            if (!empty($message['length']) && strlen($params[$field]) < $message['length']) {
                if ($thisError) {
                    array_pop($errors);
                }
                $errors[] = [
                    'field' => $field,
                    'message' => 'Некорректная длина поля <b>"' . $fieldName . '"</b>'
                ];
            }
        }

    }

    return $errors;
}

function sendOrderMessage($params)
{
    $data = [
        "USER" => $params['USER_FIO'] ?: 'Неизвестно',
        "USER_EMAIL" => $params['USER_EMAIL'] ?: '',
        "PHONE" => $params['PHONE'],
        "COUNT" => $params['COUNT'],
        "PRICE" => $params['PRICE'],
        "PRICE_STOCK" => $params['PRICE_STOCK'],
        "USE_DARK_STORE" => $params['USE_STOCK'] == 1 ? 'Да' : 'Нет',
        "STORE" => $params['STORE']['NAME'],
        "STORE_ID" => $params['STORE']['ID'],
        "STORE_XML_ID" => $params['STORE']['XML_ID'],
        "DARK_STORE" => $params['STOCK_STORE']['NAME'],
        "DARK_STORE_ID" => $params['STOCK_STORE']['ID'],
        "DARK_STORE_XML_ID" => $params['STOCK_STORE']['XML_ID'],
        "ORDER_ID" => $params['ORDER_ID'],
    ];
    $arSelect = Array("ID", "NAME", "DATE_ACTIVE_FROM", "DETAIL_PAGE_URL", "DETAIL_PICTURE");
    $arFilter = Array(
        "IBLOCK_ID" => IntVal(IBLOCK_CATALOG_ID),
        "ACTIVE_DATE" => "Y",
        "ACTIVE" => "Y",
        "ID" => $params['PRODUCT'] ?: false
    );
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 1), $arSelect);
    if ($ob = $res->GetNextElement()) {
        $arFields = $ob->GetFields();
        $data['PRODUCT_NAME'] = $arFields['NAME'];
        $data['PRODUCT_URL'] = 'https://' . XML_SITE_URL . $arFields['DETAIL_PAGE_URL'];
        $data['PRODUCT_IMG'] = '#';
        if (!empty($arFields['DETAIL_PICTURE'])) {
            $data['PRODUCT_IMG'] = 'https://' . XML_SITE_URL . CFile::getPath($arFields['DETAIL_PICTURE']);
        }

    }
    CEvent::Send("NEW_ORDER_BUY_CLICK", SITE_ID, $data);
}

function getUserByNumber($number)
{

    $currentUserId = CUser::GetID();
    $number = str_replace(['(', ')', ' ', '_', '-', '+'], '', $number);
    $fields = [
        'ID',
        'NAME',
        'EMAIL',
        'LAST_NAME',
        'SECOND_NAME'
    ];
    $select = [
        "UF_CARD_NUMBER",
    ];
    $filter = Array
    (
        "LOGIN" => $number ?: false,
    );

    $rsUsers = CUser::GetList($by = "timestamp_x", $order = "desc", $filter, ['SELECT' => $select, 'FIELDS' => $fields]); // выбираем пользователей
    if ($user = $rsUsers->GetNext()){
     return $user;
    }

    if (!empty($currentUserId) && $currentUserId > 0){

        $filter = Array
        (
            "ID" => $currentUserId ?: false,
        );
        $rsUsers = CUser::GetList($by = "timestamp_x", $order = "desc", $filter, ['SELECT' => $select, 'FIELDS' => $fields]); // выбираем пользователей
        if ($user = $rsUsers->Fetch()){

            return $user;
        }
    }
    return null;
}