/*
You can use this file with your scripts.
It will not be overwritten when you upgrade solution.
*/
$(document).on("mouseover", ".table .item-stock .icon", function(){  
    $(".value_block").fadeOut();
    $(this).next(".value_block").fadeIn();
});
$(document).on("mouseout", ".table .item-stock .icon", function(){  
    $(".value_block").fadeOut();
});