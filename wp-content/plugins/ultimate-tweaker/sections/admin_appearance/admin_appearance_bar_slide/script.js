(function($) {
    var st;
    $(function() {
//        $('html').removeClass('wp-toolbar');

        $('#wpadminbar').show();

        var show = function() {
            st && clearTimeout(st);
            $('html').addClass('wpadminbar_show');
            $('body').off('.scvg').on('click.scvg', function(event) {
                var target = $( event.target );
                if ( target.is('#wpadminbar') || target.parents('#wpadminbar').length ) {
                    return;
                }

                $('html').removeClass('wpadminbar_show');
            });
        };

        $('#wpadminbar_hover').hover(show);

        $('#wpadminbar').hover(show).mouseleave(function() {
            st = setTimeout(function() {
                $('html').removeClass('wpadminbar_show');
            }, 1500);
        });
    });
})(jQuery);