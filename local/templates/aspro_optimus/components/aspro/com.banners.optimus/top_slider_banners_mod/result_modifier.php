<?foreach($arResult["ITEMS"] as $ItemID => $arItem) {
    if(is_array($arItem["DETAIL_PICTURE"])) {
        $img = CFile::ResizeImageGet($arItem["DETAIL_PICTURE"]['ID'], array( "width" => 916, "height" => 322 ), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arItem["DETAIL_PICTURE"]['SRC'] = $img['src'];    
    }
    if(is_array($arItem["PREVIEW_PICTURE"])) {
        $img = CFile::ResizeImageGet($arItem["PREVIEW_PICTURE"]['ID'], array( "width" => 916, "height" => 916 ), BX_RESIZE_IMAGE_PROPORTIONAL, true);
        $arResult['ITEMS'][$ItemID]["PREVIEW_PICTURE"]['SRC'] = $img['src'];    
    }
}?>