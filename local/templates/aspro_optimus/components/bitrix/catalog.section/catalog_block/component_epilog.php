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
        //Слайдер
        $(".photo_miniature").on("click", function() {
            $(this).siblings(".photo_miniature").removeClass('active');       
            $(this).addClass('active'); 
            var index = $(this).index();
            $(this).parents('.item_wrap').find('.popup_photo').hide();
            $(this).parents('.item_wrap').find('.popup_photo').eq(index).show();
            if ($(this).hasClass('last') && $(this).next().is('.photo_miniature')) {
                $(this).next().fadeIn(500).addClass("last");
                $(this).removeClass("last");
                $(this).parents('.item_wrap').find('.photo_miniature.first').hide().removeClass("first").next('.photo_miniature').addClass("first");
            }            
            if ($(this).hasClass('first') && $(this).prev().is('.photo_miniature')) {
                $(this).prev().fadeIn(500).addClass("first");
                $(this).removeClass("first");
                $(this).parents('.item_wrap').find('.photo_miniature.last').hide().removeClass("last").prev('.photo_miniature').addClass("last"); 
            }                  
        });
        //Всплывающее окно
        $(".image_wrapper_block a").on("mouseover", function(){
            if ($(window).width() > '1024'){
                $('.catalog_photo_popup').hide();
                $(this).parents('.item_wrap').find('.catalog_photo_popup').show();
            }             
        });
        //Скрытие всплывающего окна
        $('.catalog_photo_popup').on("mouseleave", function(){
              $('.catalog_photo_popup').hide();        
        });         
	</script>
	<?}
}?>