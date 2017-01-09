$(document).on("mouseenter", ".table .item-stock", function(){
    $(".value_block").fadeOut();
    $(this).find(".value_block").fadeIn();
});
$(document).on("mouseleave", ".table .item-stock", function(){  
    $(".value_block").fadeOut();
});