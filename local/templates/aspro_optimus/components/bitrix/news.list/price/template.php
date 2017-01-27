<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?if($arResult["ITEMS"] && $arResult['SECTIONS']):?>
	<div class="staff list">
		<div class="items">               
			<?foreach($arResult['SECTIONS'] as $SID => $SName):?>
				<?if($arResult['ITEMS_BY_SECTIONS'][$SID]):?>
					<?if(count($arResult['SECTIONS']) > 1):?>
						<?
						// edit/add/delete buttons for edit mode
						$arSectionButtons = CIBlock::GetPanelButtons($arParams['IBLOCK_ID'], 0 , $SID, array('SESSID' => false, 'CATALOG' => true));
						$this->AddEditAction($SID, $arSectionButtons['edit']['edit_section']['ACTION_URL'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_EDIT'));
						$this->AddDeleteAction($SID, $arSectionButtons['edit']['delete_section']['ACTION_URL'], CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'SECTION_DELETE'), array('CONFIRM' => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
						?>
						<div class="staff_section" id="<?=$this->GetEditAreaId($SID)?>">
							<div class="staff_section_title"><h4><a rel="nofollow" href=""><?=$SName?></a><span class="slide opener_icon no_bg"><i></i></span></h4></div>
					<?endif;?>
							<div class="staff_section_items" style="padding: 39px !important;">                                                                   
								<?foreach($arResult['ITEMS_BY_SECTIONS'][$SID] as $arItem):?>
									<?
									$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
									$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
									if($bShowName = in_array('NAME', $arParams['FIELD_CODE'])){
										$arItem["NAME"] = trim($arItem["NAME"]);
										$arName = explode(' ', $arItem["NAME"]);
										$firstName = $arName[0];
										if($firstName != $arItem["NAME"]){
											unset($arName[0]);
											$secondName = implode(' ', $arName);
										}
										else{
											$secondName = '';
										}
									}
									$bShowImage = (in_array('PREVIEW_PICTURE', $arParams['FIELD_CODE']) || in_array('DETAIL_PICTURE', $arParams['FIELD_CODE']));
									?>             
                                                           
                                    <? if ($arParams["DISPLAY_DATE"] != "N" && $arItem["DISPLAY_ACTIVE_FROM"]): ?>
                                        <span class="news-date-time"><? echo $arItem["DISPLAY_ACTIVE_FROM"] ?></span>
                                    <? endif ?>
                                    <a href="<? echo $arItem["DISPLAY_PROPERTIES"]["PRICELIST"]["FILE_VALUE"]["SRC"] ?>"><b><? echo $arItem["NAME"] ?></b></a>   
								<?endforeach;?>
							</div>
					<?if(count($arResult['SECTIONS']) > 1):?>
						</div>
					<?endif;?>
				<?endif;?>
			<?endforeach;?>	
		</div>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
<?else:?>
	<p class="no_items"><?=GetMessage("NO_STAFF");?></p>
<?endif;?>
<script type="text/javascript">
$(document).ready(function() {
	setTimeout(function() {
		$('.staff.list .staff_section:first .staff_section_title a').trigger('click');
	}, 300);
});
</script>