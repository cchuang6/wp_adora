(function($) {
    var $win = $(window);

    var sprintf = function(){
        var args = Array.prototype.slice.call(arguments);
        return args.shift().replace(/%s/g, function(){
            return args.shift();
        });
    }

    var roleManager = function() {
        var me = this;
        me.inited = false;
    };

    roleManager.prototype = {
        init: function() {
            var me = this,
                $body = $('body');
            if(me.inited) return;
            me.inited = true;

            me.close = $.proxy(me.close, me);
            me.createRole = $.proxy(me.createRole, me);

            me.$list = $('<div class="ut_role_manager_dialog_list"></div>');
            me.$form = $('<div class="ut_role_manager_dialog_form"></div>');
            me.$dialog = $('<div id="ut_role_manager_dialog_body">' + '</div>');
            me.$dialog.append(me.$list);
            me.$dialog.append(me.$form);

            $body.append(me.$dialog);
        },
        show: function() {
            var me = this;

            me.init();

            me.$dialog.dialog({
                modal        : true,
                create       : function (event, ui) {
                    $(event.target).parent().css('position', 'fixed');
                },
                resizeStop   : function (event, ui) {
                    var position = [(Math.floor(ui.position.left) - $win.scrollLeft()),
                        (Math.floor(ui.position.top) - $win.scrollTop())];
                    $(event.target).parent().css('position', 'fixed');
                    me.$dialog.dialog('option', 'position', position);
                },
                dialogClass  : 'ut_jquery_ui_dialog ut_role_manager_dialog',
                title        : roleManagerConfig.title,
                closeOnEscape: true,
//                resizable    : false,
                minHeight    : '600',
                height       : $(window).height() * .9,//'600',
//                maxHeight: maxHeight,
                width        : '800',
//                width    : '800',
                autoOpen     : true,

                buttons: [
                    {
                        text : roleManagerConfig.cancel,
                        click: me.close
                    },
                    {
                        text : roleManagerConfig.save,
                        class: 'ut_button_primary',
                        click: function () {
                            me.saveData(me.close);
                        }
                    }
                ]
            }).on("dialogclose", function () {
                me.$list.empty();
                me.$form.empty();

                me.$createRoleForm && me.$createRoleForm.dialog( "close" );
            });

            me.loadData();
        },

        close: function() {
            var me = this;
            me.$dialog.dialog( "close" );
        },
        setLoading: function(visible, text) {
            var me = this;
            text = text || roleManagerConfig.loading;

            if(!me.$loading) {
                me.$loadingWrap = $('<div/>');
                me.$loading = $('<div/>', { class:'ut_role_manager_dialog_loading' });
                me.$loading.append(me.$loadingWrap);
                $('.ut_role_manager_dialog').append(me.$loading);
            }
            if(visible) {
                me.$loadingWrap.html(text);
                me.$loading.css('top', $('.ut_role_manager_dialog .ui-dialog-titlebar').outerHeight());
                me.$loading.fadeIn('fast');
            } else {
                me.$loading.fadeOut('fast');
            }
        },

        loadData: function() {
            var me = this;

            me.data = null;
            me.setLoading(true);

            $.post(ajaxurl, { action: 'ut_rm_get', _wpnonce: roleManagerConfig.nonce }, function(data) {
                if(data <= 0) {
                    console.log(data);
                    return;
                }

                me.data = data.roles;
                $.each(me.data, function(roleId, roleMeta) {
                    if(!roleMeta.hasOwnProperty('capabilities') || !roleMeta.capabilities || !$.isPlainObject(roleMeta.capabilities))
                        me.data[roleId].capabilities = {};
                });

                me.deprecated_capabilities = data.deprecated_capabilities;
                me.outputData();

                me.setLoading(false);
            });
        },

        saveData: function(cb) {
            var me = this;

            me.setLoading(true, roleManagerConfig.saving);

            $.post(ajaxurl, { action: 'ut_rm_save', data: me.data, _wpnonce: roleManagerConfig.nonce }, function(data) {
                if(data <= 0) {
//                    console.log(data);
                    alert('Error.');
                    return;
                }
//                console.log(data);

                me.data = null;
                cb();
                me.setLoading(false);
            });
        },

        outputData: function() {
            var me = this,
                data = me.data;

            me.$list.empty();
            me.$form.empty();
            var $ul = $('<ul/>');

            $.each(data, function(roleId, roleMeta) {
                if(roleMeta.isDeleted) return;
                var $li = $('<li data-role-id="'+roleId+'" title="'+roleId+'">'+roleMeta.name+'</li>');
                if(roleId != 'administrator') $li.append($('<div data-action="delete" class="dashicons dashicons-trash"></li>'));
                $li.append($('<div data-action="rename" class="dashicons dashicons-edit"></li>'));
                $ul.append($li);
            })

            $ul.append('<hr/>');
            var $createRoleLi = $('<li data-action="create-role">'+roleManagerConfig.createRole+'</li>');
            $createRoleLi.click(me.createRole);
            $ul.append($createRoleLi);

            me.$list.append($ul);
            $ul.on('click', '[data-role-id]', function() {
                var $li = $(this),
                    roleId = $li.data('roleId');

                $ul.find('li').not($li).removeClass('selected');
                $li.addClass('selected');

                me.outputForm(roleId);
            });

            me.$list.off('click.ut_role_actions').on('click.ut_role_actions', '[data-action]', function(e) {
                e.preventDefault();
                e.stopPropagation();

                var $el = $(this),
                    $li = $el.parents('[data-role-id]'),
                    roleId = $li.data('roleId'),
                    action = $el.data('action');

                if(action == 'rename') {
                    var promptName = function(current, cb) {
                        var name = prompt(roleManagerConfig.newRoleNameConfirmation, current);
                        if(name) {
                            if (name.length > 32 || name.length < 3) {
                                alert(sprintf(roleManagerConfig.form_checkLengthMessage, roleManagerConfig.form_Name, 3, 32));
                                promptName(name, cb);
                                return;
                            }

                            $.each(me.data, function(i, meta) {
                                if(meta['name'] == name) {
                                    alert( roleManagerConfig.form_checkRoleNameExistsMessage );
                                    promptName(name, cb);
                                    return;
                                }
                            });

                            cb(name);
                        }
                    };
                    promptName(data[roleId].name, function(name) {
                        me.data[roleId].name = name;
                        me.outputData();
                    });
                } else if(action == 'delete' && confirm(roleManagerConfig.deleteConfirmation)) {
                    me.data[roleId].isDeleted = true;
                    me.outputData();
                }
            });

            $ul.find('li:first').click();
        },

        outputForm: function(roleId) {
            var me = this,
                data = me.data,
                capabilities = data[roleId].capabilities;

            var allCapabilities = me.readAllCapabilities();

            me.$form.empty();
            var $cont = $('<div class="ut_role_manager_dialog_body_wrap"/>');

            $.each(allCapabilities, function(i, group) {
                var name = group.name,
                    caps = group.caps;

                var $group = $('<div/>', { class: 'ut_rm_group' });
                var $groupBody = $('<div/>', { class: 'ut_rm_group_body' });
                var $h3 = $('<h3/>', { html: name });
                $h3.append($('<a/>', { class:'ut_rm_group_checkall', html: 'Check all' }));
                $h3.append($('<span/>', { html: '/' }));
                $h3.append($('<a/>', { class:'ut_rm_group_uncheckall', html: 'Uncheck all' }));
                $group.append($h3).append($groupBody);

                $.each(caps, function(capabilityId, capabilityName) {
                    var isDisabled = false;
                    if(roleId == 'administrator') {
                        isDisabled = true;
                    }
                    if(capabilityId == 'manage_options' && (roleId == 'administrator' || roleId == 'ut_administrator')) {
                        isDisabled = true;
                    }

                    var $label = $('<label/>', { 'for': 'capability-' + capabilityId });
                    var $input = $('<input/>', {
                        id: 'capability-' + capabilityId,
                        name: capabilityId,
                        type:'checkbox',
                        disabled: isDisabled,
                        checked: capabilities[capabilityId]
                    });
                    $label.append($input).append(capabilityName);
                    $groupBody.append($label);
                });

                $cont.append($group);
            });

            me.$form.append($cont);
            me.$form.off('change.checkbox').on('change.checkbox', 'input[type=checkbox]', function() {
               var $checkbox = $(this),
                   selectedRole = me.$list.find('li.selected').data('roleId');

                if(!me.data[selectedRole].capabilities || $.isArray(me.data[selectedRole].capabilities)) me.data[selectedRole].capabilities = {};
                me.data[selectedRole].capabilities[$checkbox.prop('name')] = $checkbox.prop('checked') ? true : false;
            });


            me.$form.off('click.uncheck').on('click.uncheck', '.ut_rm_group_uncheckall', function(e) {
                e.preventDefault();
                var $checkboxes = $(this).parents('.ut_rm_group').find('input[type=checkbox]').not('[disabled]');
                $checkboxes.prop('checked', false).trigger('change');
            });
            me.$form.off('click.check').on('click.check', '.ut_rm_group_checkall', function(e) {
                e.preventDefault();
                var $checkboxes = $(this).parents('.ut_rm_group').find('input[type=checkbox]').not('[disabled]');
                $checkboxes.prop('checked', true).trigger('change');
            });

//            console.log(roleId, capabilities);
        },

        readAllCapabilities: function() {

            var me = this,
                data = me.data,
                usedCaps = [];

            var capitalizeFirstLetter = function(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            };

            var capsData = {};
            capsData['Dashboard'] = ['read', 'edit_dashboard'];
            capsData['Posts'] = ['publish_posts', 'edit_posts', 'delete_posts', 'edit_published_posts', 'delete_published_posts', 'edit_others_posts', 'delete_others_posts', 'read_private_posts', 'edit_private_posts', 'delete_private_posts', 'manage_categories'];
            capsData['Media'] = ['upload_files', 'unfiltered_upload'];
            capsData['Pages'] = ['publish_pages', 'edit_pages', 'delete_pages', 'edit_published_pages', 'delete_published_pages', 'edit_others_pages', 'delete_others_pages', 'read_private_pages', 'edit_private_pages', 'delete_private_pages'];
            capsData['Comments'] = ['edit_comment', 'moderate_comments'];
            capsData['Themes'] = ['switch_themes', 'edit_theme_options', 'edit_themes', 'delete_themes', 'install_themes', 'update_themes'];
            capsData['Plugins'] = ['activate_plugins', 'edit_plugins', 'install_plugins', 'update_plugins', 'delete_plugins'];
            capsData['Users'] = ['list_users', 'create_users', 'edit_users', 'delete_users', 'promote_users', 'add_users', 'remove_users'];
            capsData['Tools'] = ['import', 'export'];
            capsData['Admin'] = ['manage_options', 'update_core', 'unfiltered_html'];
            capsData['Links'] = ['manage_links'];

            var caps = [];
            $.each(capsData, function(group, capabilities) {
                var groupCaps = {};
                $.each(capabilities, function(i, capabilityId) {
                    usedCaps.push(capabilityId);
                    var name = capitalizeFirstLetter(capabilityId.replace(/_/g, ' '));
                    groupCaps[capabilityId] = name;
                });

                caps.push({
                    name: group,
                    caps: groupCaps
                });
            });

            var group = 'Other Capabilities';
            var groupCaps = {};
            $.each(data, function(role, roleMeta) {
                $.each(roleMeta.capabilities, function(capabilityId) {
                    if(usedCaps.indexOf(capabilityId) >= 0) return;
                    if(me.deprecated_capabilities.hasOwnProperty(capabilityId)) return;
                    if(!groupCaps[capabilityId]) {
                        var name = capitalizeFirstLetter(capabilityId.replace(/_/g, ' '));
                        groupCaps[capabilityId] = name;
                    }
                })
            });
            caps.push({
                name: group,
                caps: groupCaps
            });

            return caps;
        },

        createRole: function(e) {
            var me = this;
            e.preventDefault();

            if(me.$createRoleForm) {
                me.$createRoleForm.dialog( "close" );
            }

            me.$createRoleForm = $('<div id="ut_rm_create_role_form">' +
                '<p class="validateTips">' + roleManagerConfig.form_allRequired +'</p>' +
                '<form><fieldset>' +
                '<label for="ut_cr_id">' + roleManagerConfig.form_ID +'</label><input type="text" name="id" id="ut_cr_id" value="" class="">' +
                '<label for="ut_cr_name">' + roleManagerConfig.form_Name +'</label><input type="text" name="name" id="ut_cr_name" value="" class="">' +
                '</fieldset></form></div>');

            $('body').append(me.$createRoleForm);


            var checkLength = function( o, n, min, max ) {
                if ( o.val().length > max || o.val().length < min ) {
                    o.addClass( "ui-state-error" );
                    form_updateTips( sprintf(roleManagerConfig.form_checkLengthMessage, n, min, max) );
                    return false;
                } else {
                    return true;
                }
            }
            var checkRegexp = function( o, regexp, n ) {
                if ( !( regexp.test( o.val() ) ) ) {
                    o.addClass( "ui-state-error" );
                    form_updateTips( n );
                    return false;
                } else {
                    return true;
                }
            }

            var form_updateTips = function( t ) {
                var $tips = me.$createRoleForm.find('.validateTips');
                $tips.text( t ).addClass( "ui-state-highlight" );
                setTimeout(function() {
                    $tips.removeClass( "ui-state-highlight", 1500 );
                }, 500 );
            }

            var submit = function() {
                var valid = true,
                    $id = me.$createRoleForm.find('[name=id]'),
                    $name = me.$createRoleForm.find('[name=name]'),
                    $all = $([]).add($id).add($name);

                $all.removeClass( "ui-state-error" );

                valid = valid && checkLength( $id, roleManagerConfig.form_ID, 3, 16 );
                valid = valid && checkRegexp( $id, /^[a-z]([0-9a-z_])+$/i, roleManagerConfig.form_checkRoleIDRegExpMessage );
                valid = valid && checkLength( $name, roleManagerConfig.form_Name, 3, 32 );
                if(valid) {
                    if(me.data.hasOwnProperty($id.val())) {
                        $id.addClass( "ui-state-error" );
                        form_updateTips( roleManagerConfig.form_checkRoleIDExistsMessage );
                        valid = false;
                    }
                }
                if(valid) {
                    var name = $name.val();
                    $.each(me.data, function(i, meta) {
                        if(meta['name'] == name) {
                            $name.addClass( "ui-state-error" );
                            form_updateTips( roleManagerConfig.form_checkRoleNameExistsMessage );
                            valid = false;
                        }
                    });
                }

                if(valid) {
                    var nameUCFIRST = $name.val();
                    me.data[$id.val()] = {
                        name        : nameUCFIRST.charAt(0).toUpperCase() + nameUCFIRST.substr(1),
                        capabilities: {},
                        isCreated   : true
                    };
                    me.$createRoleForm.dialog("close");
                    me.outputData();
                }
            };

            me.$createRoleForm.dialog({
                dialogClass  : 'ut_jquery_ui_dialog',
                modal: true,
                closeOnEscape: true,
                minWidth        : 350,
                title        : roleManagerConfig.createRoleTitle,
                buttons      : [
                    {
                        text : roleManagerConfig.cancel,
                        click: function () {
                            me.$createRoleForm.dialog("close");
                        }
                    },
                    {
                        text : roleManagerConfig.create,
                        class: 'ut_button_primary',
                        click: submit
                    }
                ],
                close        : function () {
                    me.$createRoleForm.remove();
                    me.$createRoleForm = null;
                }
            });
        }
    };

    var rm = new roleManager();

    $(function() {
       $('.ut_role_manager_a').click(function(e) {
           e.preventDefault();

           rm.show();
       });
    });
})(jQuery);