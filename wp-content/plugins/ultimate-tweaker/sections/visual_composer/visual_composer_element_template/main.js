!(function($) {

    //var _currentElement;

    var loadTemplateList = function(currentElement) {
        var $list = $('.element-template-list');
        $list.html('');

        if(!VCElementTemplateData || !VCElementTemplateData[currentElement] || !$.isPlainObject(VCElementTemplateData[currentElement])) {
            $list.html('<li class="empty">empty</li>');
            return;
        }

        var templates = VCElementTemplateData[currentElement];
        $.each(templates, function(title, data) {
            $li = $('<li><a>'+title+'</a><i class="remove"></i></li>');
            $li.click(function(ev) {
                //ev.preventDefault();
                //ev.stopPropagation();

                var $form = $('.vc_shortcode-edit-form');

                //console.log(data)
                $.each(data, function(name, value) {
                    var $input = $form.find('[name="'+name+'"]'),
                        type = $input.attr('type');

                    //if(name == 'simply') return;
                    if(name == 'css') return;
                    if($input.hasClass('vc_alpha-field')) return;

                    if(type == 'radio') {}
                    else if(type == 'checkbox') {
                        var _current = $input.prop('checked'),
                            _new = (value == 'true' && value != 'false') ?true:false;
                        $input.prop('checked', _new);
                        if(_current != _new && name != 'simply') $input.trigger('change');
                    } else if($input.hasClass('gallery_widget_attached_images_ids')) {
                        var ids = value.toString().split(',');
                        var $list = $input.closest('.edit_form_line').find('.gallery_widget_attached_images_list');
                        $list.html('');
                        $input.val(value);

                        $.each(ids, function(_k, id) {
                            if(!id) return;

                            var $html = $(_.template($('#vc_settings-image-block').html(), {id: id, url: 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACwAAAAAAQABAAACAkQBADs='}));
                            $list.append($html);

                            $.ajax({
                                type:'POST',
                                url:window.ajaxurl,
                                data:{
                                    action:'wpb_single_image_src',
                                    content:id
                                },
                                dataType:'html',
                                context:this
                            }).done(function (src) {
                                $html.find('img').prop('src', src);
                            });
                        });
                    } else if($input.hasClass('vc_color-control')) {//vc_color-control wp-color-picker
                        $input.val(value).trigger('change');
                        try {
                            $input.iris('color', value);
                        } catch(e) {}

                        if(!value && value == '') {
                            $input.closest('.vc_color-picker').find('.wp-color-result').css('backgroundColor', '');
                        }

                        if(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)) {
                            var alpha_val = parseFloat(value.match(/rgba\(\d+\,\d+\,\d+\,([^\)]+)\)/)[1])*100;

                            $alpha = $input.closest('.vc_color-picker').find('.vc_alpha-field');
                            $alpha_output = $input.closest('.vc_color-picker').find('.rangevalue');
                            $alpha.val(alpha_val);
                            $alpha_output.val(alpha_val + '%');
                        }

                    } else if(name == 'wpb_tinymce_content' && tinymce) {
                        var c = tinymce.get( 'wpb_tinymce_content');
                        c.setContent(value);
                    } else {
//                        console.log(name, value);
                        $input.val(value).trigger('change');
                    }

                    //console.log(value, name)
                });
                //debugger;
            });
            $li.find('i').click(function(ev) {
                ev.preventDefault();
                ev.stopPropagation();
                if(!confirm('Do you really wanna delete?')) return;

                $.ajax({
                    type: "POST",
                    url :VCElementTemplateSettings.ajaxurl,
                    data:{
                        action : 'vc_et_remove_template',
                        element : currentElement,
                        name : title,
                        nonce : VCElementTemplateSettings.nonce
                    },
                    dataType: 'json',
                    success:function( response ) {
                        if(response.success && response.data && $.isPlainObject(response.data)) {
                            VCElementTemplateData = response.data;
                            loadTemplateList(currentElement);
                        }
                        //console.log(response)
                    },
                    error:function( response ) {  }
                });
            });
            $list.append($li);
        })
    };

    window.VCElementTemplateLoad = function() {//currentElement
        //_currentElement = currentElement;
        var currentElement = window.vc.active_panel.model.get('shortcode');
        loadTemplateList(currentElement);

        $('.element-template-add')
            .off('save-template')
            .on('save-template', function(event, name, values) {
                //console.log(arguments);

                $.ajax({
                    type: "POST",
                    url :VCElementTemplateSettings.ajaxurl,
                    data:{
                        action : 'vc_et_save_template',
                        element : currentElement,
                        name : name,
                        values : values,
                        nonce : VCElementTemplateSettings.nonce
                    },
                    dataType: 'json',
                    success:function( response ) {
                        if(response.success && response.data && $.isPlainObject(response.data)) {
                            VCElementTemplateData = response.data;
                            loadTemplateList(currentElement);
                        }
                        //console.log(response)
                    },
                    error:function( response ) {  }
                });
            })
    };

    $(function() {
        $('#vc_properties-panel').each(function() {
            var $this = $(this);
            var $footer = $('.vc_panel-footer', this);
            $footer.append(
                '<div class="element-template-container">' +
                    '<button type="button" class="vc_btn vc_btn-default element-template-button">Element Template <i class="up"></i></button>' +
                    '<ul>' +
                        '<li class="element-template-add"><a>Save current...</a></li>' +
                        '<li class="divider"></li>' +
                        '<span class="element-template-list">' +
                        '</span>' +
                    '</ul>' +
                '</div>');

            $footer.find('.element-template-add').on('click', function() {
                //$fields = $this.find('.wpb_vc_param_value');
//                $fields = $this.find('input,select,textarea').not('[type=button]').not('[type=radio]');
                $fields = $this.find('.wpb_vc_param_value');//.not('[type=button]').not('[type=radio]');

                var values = {};
                $fields.each(function() {
                    var $field = $(this),
                        name = $field.attr('name'),
                        type = $field.attr('type'),
                        val;

                    //if(name == 'content') return;

                    if(type == 'checkbox') {
                        val = $field.is(':checked');
                    } else {
                        val = $field.val();
                    }

                    values[name] = val;
                });

                var name = prompt("Enter name of template: ", "");
                if(!name) return;


                $(this).trigger('save-template', [name, values]);
            });
        });
    });
}(jQuery));