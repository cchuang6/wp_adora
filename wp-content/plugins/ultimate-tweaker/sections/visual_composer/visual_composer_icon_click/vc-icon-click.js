(function($) {
    $(function() {
        $(document.body).on('click', '.vc_element-icon', function() {
            var $el = $(this),
                $holder = $el.closest('.wpb_content_element, .wpb_content_holder'),
                $edit = $holder.find('> .vc_controls > .column_edit, > .vc_controls .vc_controls-cc > .vc_control-btn-edit');
            $edit.click();
        });
    });
})(jQuery);