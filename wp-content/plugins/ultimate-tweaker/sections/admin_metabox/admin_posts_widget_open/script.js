jQuery(document).ready( function($) {
    jQuery('.postbox').filter('.closed').each(function() {
        var p = $(this), id = p.attr('id');

        if ( 'dashboard_browser_nag' == id )
            return;

        p.removeClass('closed');

//        if ( page != 'press-this' )
//            self.save_state(page);

        if ( id ) {
            if ( $.isFunction(postboxes.pbshow) ) self.pbshow(id);
        }

        $(document).trigger( 'postbox-toggled', p );
    });
});