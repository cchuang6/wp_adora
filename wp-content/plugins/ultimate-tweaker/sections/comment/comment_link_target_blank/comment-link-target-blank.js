(function($) {
    $(function() {
        $('#comments').find('a[href^=http]').each(function() {
            if (this.href.indexOf(location.hostname) > -1) return;

            $(this).attr('target', '_blank');
        });
    });
})(jQuery);