(function ($) {
    $(window).keyup(function(e){
        if(e.keyCode == 44){
            $("body").hide();
            setTimeout(function() {
                $("body").show();
            }, 2000);
        }
    });
})(jQuery);