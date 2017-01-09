<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");
?><div class="contacts_map">
	 <?$APPLICATION->IncludeComponent(
	"bitrix:map.google.view",
	"map",
	Array(
		"API_KEY" => "",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"CONTROLS" => array(),
		"INIT_MAP_TYPE" => "ROADMAP",
		"MAP_DATA" => "a:4:{s:10:\"google_lat\";d:55.839673999999995;s:10:\"google_lon\";d:37.652491;s:12:\"google_scale\";i:16;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:4:\"TEXT\";s:0:\"\";s:3:\"LON\";d:37.653772830963135;s:3:\"LAT\";d:55.83972625700614;}}}",
		"MAP_HEIGHT" => "400",
		"MAP_ID" => "",
		"MAP_WIDTH" => "100%",
		"OPTIONS" => array("ENABLE_DBLCLICK_ZOOM","ENABLE_DRAGGING"),
		"ZOOM_BLOCK" => array("POSITION"=>"right center",)
	)
);?>
</div>
<div class="wrapper_inner">
	<div class="contacts_left">
		<div class="store_description">
			<div class="store_property">
				<div class="title">
					 Адрес
				</div>
				<div class="value">
					 <?$APPLICATION->IncludeFile(SITE_DIR."include/address.php", Array(), Array("MODE" => "html", "NAME" => "Адрес"));?>
				</div>
			</div>
			<div class="store_property">
				<div class="title">
					 Телефон
				</div>
				<div class="value">
					 <?$APPLICATION->IncludeFile(SITE_DIR."include/phone.php", Array(), Array("MODE" => "html", "NAME" => "Телефон"));?>
				</div>
			</div>
			<div class="store_property">
				<div class="title">
					 Email
				</div>
				<div class="value">
					 <?$APPLICATION->IncludeFile(SITE_DIR."include/email.php", Array(), Array("MODE" => "html", "NAME" => "Email"));?>
				</div>
			</div>
			<div class="store_property">
				<div class="title">
					 Режим работы
				</div>
				<div class="value">
					 <?$APPLICATION->IncludeFile(SITE_DIR."include/schedule.php", Array(), Array("MODE" => "html", "NAME" => "Время работы"));?>
				</div>
			</div>
		</div>
	</div>
	<div class="contacts_right">
		<blockquote>
			 <?$APPLICATION->IncludeFile(SITE_DIR."include/contacts_text.php", Array(), Array("MODE" => "html", "NAME" => GetMessage("CONTACTS_TEXT")));?>
		</blockquote>
		 <?Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("form-feedback-block");?> <?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"inline",
	Array(
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "?send=ok",
		"USE_EXTENDED_ERRORS" => "Y",
		"VARIABLE_ALIASES" => Array("WEB_FORM_ID"=>"WEB_FORM_ID","RESULT_ID"=>"RESULT_ID"),
		"WEB_FORM_ID" => "5"
	)
);?> <?Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("form-feedback-block", "");?>
	</div>
</div>
<div class="clearboth">
</div>
<br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>