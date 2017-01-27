<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?><?php
if(is_null($_GET[init_off])) {
    if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/bitrix/php_interface/functions.php")) {
        require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/functions.php");
    }
}

define("HIT_NEW_XML_ID", "155"); //ID значения с "Новыми поступлениями" у списка отвчечающего за вывод товаров на главной странице
             
AddEventHandler("catalog", "OnGetOptimalPrice", "MyGetOptimalPrice");

function MyGetOptimalPrice($productID, $quantity = 1, $arUserGroups = array(), $renewal = "N", $arPrices = array(), $siteID = false, $arDiscountCoupons = false)
{
    global $LocalPrice;
    if($LocalPrice <= 0)
    {
        // Р’С‹РІРµРґРµРј Р°РєС‚СѓР°Р»СЊРЅСѓСЋ РєРѕСЂР·РёРЅСѓ РґР»СЏ С‚РµРєСѓС‰РµРіРѕ РїРѕР»СЊР·РѕРІР°С‚РµР»СЏ
        $dbBasketItems = CSaleBasket::GetList(false,
            array(
                "FUSER_ID" => CSaleBasket::GetBasketUserID(),
                "LID" => SITE_ID,
                "ORDER_ID" => "NULL"
                ),
            false,
            false,
            array("ID", "MODULE", "PRODUCT_ID", "CALLBACK_FUNC", "QUANTITY", "DELAY", "CAN_BUY", "PRICE")
        );
        while ($arItem = $dbBasketItems->Fetch())
        {
            if($arItem['DELAY'] == 'N' && $arItem['CAN_BUY'] == 'Y')
            {
                $LocalPrice += $arItem['PRICE']*$arItem['QUANTITY'];
            }
        }
    }

    //РћРџРў 1 РїСЂРё СЃСѓРјРјРµ Р·Р°РєР°Р·Р° РґРѕ 5 000 СЂСѓР±Р»РµР№
    //РћРџРў 2 РїСЂРё СЃСѓРјРјРµ Р·Р°РєР°Р·Р° РґРѕ 50 000 СЂСѓР±Р»РµР№
    //РћРџРў 3 РїСЂРё СЃСѓРјРјРµ Р·Р°РєР°Р·Р° Р±РѕР»РµРµ 50 000 СЂСѓР±Р»РµР№

    // РїРѕР»СѓС‡Р°РµРј РІСЃРµ С‚РёРїС‹ С†РµРЅ, РІРѕР·РјРѕР¶РЅС‹Рµ РґР»СЏ РґР°РЅРЅРѕРіРѕ С‚РѕРІР°СЂР°
    $arOptPrices = CCatalogProduct::GetByIDEx($productID);

    if($LocalPrice < 30000){
        $price = $arOptPrices['PRICES'][4]['PRICE'];
        $catalog_group_id = 4;
    }
    elseif($LocalPrice >= 30000 and $LocalPrice < 80000){
        $price = $arOptPrices['PRICES'][7]['PRICE'];
        $catalog_group_id = 7;
    }
    elseif($LocalPrice >= 80000){
        $price = $arOptPrices['PRICES'][8]['PRICE'];
        $catalog_group_id = 8;
    }

    return array(
        'PRICE' => array(
            "ID" => $productID,
            'CATALOG_GROUP_ID' => $catalog_group_id,
            'PRICE' => $price,
            'CURRENCY' => "RUB",
            'ELEMENT_IBLOCK_ID' => $productID,
            'VAT_INCLUDED' => "Y",
        ),
        'DISCOUNT' => array(
            'VALUE' => $discount,
            'CURRENCY' => "RUB",
        ),
    );
}


// Р¤СѓРЅРєС†РёСЏ РґР»СЏ РѕС‚Р»Р°РґРєРё //
function print_rr($val) {
    echo '<pre>';
    print_r($val);
    echo '</pre>';
}

// РџРѕР»СѓС‡РµРЅРёРµ С‚РµРєСѓС‰РµРіРѕ С„РѕРЅР° //
function func_current_background($iblock_id) {

    if(!CModule::IncludeModule("iblock") || empty($iblock_id)) {
        return false;
    }

    $result = false;
    $arFilter = array("IBLOCK_ID" => $iblock_id, "ACTIVE" => "Y", "ACTIVE_DATE" => "Y");
    $arSelect = array("ID", "IBLOCK_ID", "NAME", "CODE", "DETAIL_PICTURE");
    $rsElement = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);

    if($obElement = $rsElement->GetNextElement()) {
        $arElement = $obElement->GetFields();
        if ($arElement["DETAIL_PICTURE"]) {
            $arElement["DETAIL_PICTURE"] = CFile::GetFileArray($arElement["DETAIL_PICTURE"]);
        }
    }

    if(!empty($arElement["DETAIL_PICTURE"]["SRC"])) {
        $result = $arElement["DETAIL_PICTURE"]["SRC"];
    }

    return $result;
}


AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("SVC", "OnAfterIBlockElementAddHandler"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("SVC", "OnAfterIBlockElementUpdateHandler"));

class SVC
{
    // РґР»СЏ РќРѕРІС‹С… РїСЂРѕРґСѓРєС‚РѕРІ
    function OnAfterIBlockElementAddHandler(&$arFields)
    {
        if($arFields["ID"]>0&&$arFields["IBLOCK_ID"]=="3") {
             CIBlockElement::SetPropertyValues($arFields['ID'], "3", "14", "119");
        }
    }
     function OnAfterIBlockElementUpdateHandler(&$arFields)
    {
         if($arFields["ID"]>0&&$arFields["IBLOCK_ID"]=="3") {

          $res = CIBlockElement::GetByID($arFields['ID']);
           $ar_res = $res->GetNext();
           if($ar_res['TIMESTAMP_X']!=$ar_res['DATE_CREATE']) {
                 CIBlockElement::SetPropertyValues($arFields['ID'], "3", "0", "119");
            }
        }
    }
}


    function arshow($array, $adminCheck = false){
        global $USER;
        $USER = new Cuser;
        if ($adminCheck) {
            if (!$USER->IsAdmin()) {
                return false;
            }
        }
        echo "<pre>";
            print_r($array);
        echo "</pre>";
    }

AddEventHandler("catalog", "OnBeforeProductUpdate", "QuantityAddHeandler");

// создаем обработчик события "OnBeforeIblockElementUpdate"
// Меняем значение множественного свойства с топами
function QuantityAddHeandler($ID, &$arFields) {
    $element_quantity = CCatalogProduct::GetList(
            array("QUANTITY" => "DESC"),
            array("ID" => $ID),
            false,
            false
        )->Fetch();            
    //Собираем значения списка с множественным значением до обновления
    $db_hitValue = CIBlockElement::GetProperty($element_quantity["ELEMENT_IBLOCK_ID"], $ID, array("sort" => "asc"), Array("CODE" => "HIT"));
    while ($ob = $db_hitValue->GetNext()) { 
        $hitValue[] = $ob['VALUE'];
    }
    $newHit = '';                                    
    //Если после обновления менялось количество товара убираем значение "свежие поступления" из свойства элемента
    foreach ($hitValue as $hitValueID => $propertyHitId) { 
        if ($propertyHitId == HIT_NEW_XML_ID) {
            if (!empty($arFields["QUANTITY"])) {
                $newHit = 'Y';
                array_splice($hitValue, $hitValueID, 1);                 
            }                    
        }          
    }         
    //Если после обновления менялось количество товара устанавливаем значение "свежие поступления" если нужные условия выполнились                                                
    if (!empty($arFields["QUANTITY"])) {
        if (($element_quantity["QUANTITY"] <= 0 && $arFields["QUANTITY"] > $element_quantity["QUANTITY"])
            || ($element_quantity["QUANTITY"] > 0 && $element_quantity["QUANTITY"] == $arFields["QUANTITY"] && $newHit == "Y")) {
                array_push($hitValue, HIT_NEW_XML_ID);  // свойству "свежие поступления" присваиваем значение "Y" 
        }
        CIBlockElement::SetPropertyValuesEx($ID, false, array("HIT" => $hitValue));  // обновляем элемент
    }                                                                                                                    
}
?>