(function($) {
    $(function() {
        Mousetrap.bindGlobal('mod+enter', function(e) {
            var $panel = $('.vc_panel:visible');
            if($panel.length && $panel.is(':visible')) {
                $panel.find('.vc_btn-primary').click();
                e.preventDefault();
            }
        });
    });
})(jQuery);