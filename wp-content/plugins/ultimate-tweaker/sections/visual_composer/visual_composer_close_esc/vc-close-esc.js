(function($) {
    Mousetrap.bindGlobal('esc', function(e) {
        var $panel = $('.vc_panel:visible');
        if($panel.length && $panel.is(':visible')) {
            $panel.find('.vc_close').click();
            e.preventDefault();
        }
    });
})(jQuery);