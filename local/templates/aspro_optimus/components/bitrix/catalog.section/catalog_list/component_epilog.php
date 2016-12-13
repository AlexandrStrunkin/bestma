<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $templateData */
/** @var @global CMain $APPLICATION */
use Bitrix\Main\Loader;
if (isset($templateData['TEMPLATE_LIBRARY']) && !empty($templateData['TEMPLATE_LIBRARY'])){
	$loadCurrency = false;
	if (!empty($templateData['CURRENCIES']))
		$loadCurrency = Loader::includeModule('currency');
	CJSCore::Init($templateData['TEMPLATE_LIBRARY']);
	if ($loadCurrency){?>
	<script type="text/javascript">
		BX.Currency.setCurrencies(<? echo $templateData['CURRENCIES']; ?>);
        //ќбработка слайдера всплывающего окна или лежащего на странице
        $(".photo_miniature").on("mouseover", function() {
            if ($(this).hasClass("list")) {
                $(this).siblings(".photo_miniature.list").removeClass('active');       
                $(this).addClass('active'); 
                var index = $(this).index();
                $(this).parents('.image_block').find('.thumb').hide();
                $(this).parents('.image_block').find('.thumb').eq(index).show();
                if ($(this).hasClass('last') && $(this).next().is('.photo_miniature.list')) {
                    $(this).next().fadeIn(500).addClass("last");
                    $(this).removeClass("last");
                    $(this).parents('.image_block').find('.photo_miniature.list.first').hide().removeClass("first").next('.photo_miniature.list').addClass("first");
                }            
                if ($(this).hasClass('first') && $(this).prev().is('.photo_miniature.list')) {
                    $(this).prev().fadeIn(500).addClass("first");
                    $(this).removeClass("first");
                    $(this).parents('.image_block').find('.photo_miniature.list.last').hide().removeClass("last").prev('.photo_miniature.list').addClass("last"); 
                }    
            } else {                    
                $(this).siblings(".photo_miniature").removeClass('active');       
                $(this).addClass('active'); 
                var index = $(this).index();
                $(this).parents('.catalog_photo_popup').find('.popup_photo').hide();
                $(this).parents('.catalog_photo_popup').find('.popup_photo').eq(index).show();
                if ($(this).hasClass('last') && $(this).next().is('.photo_miniature')) {
                    $(this).next().fadeIn(500).addClass("last");
                    $(this).removeClass("last");
                    $(this).parents('.catalog_photo_popup').find('.photo_miniature.first').hide().removeClass("first").next('.photo_miniature').addClass("first");
                }            
                if ($(this).hasClass('first') && $(this).prev().is('.photo_miniature')) {
                    $(this).prev().fadeIn(500).addClass("first");
                    $(this).removeClass("first");
                    $(this).parents('.catalog_photo_popup').find('.photo_miniature.last').hide().removeClass("last").prev('.photo_miniature').addClass("last"); 
                }
            }                  
        });
        //¬сплывающее окно
        $(".image_wrapper_block a").on("mouseover", function(){
            $('.catalog_photo_popup').hide();
            $(this).parents('.item_wrap').find('.catalog_photo_popup').show();             
        });
        //«акртие всплывающего окна
        $('.catalog_photo_popup').on("mouseleave", function(){
              $('.catalog_photo_popup').hide();        
        });
	</script>
	<?}
}?>