(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
/**
 * Created by Amino-Studio.
 * Url: http://amino-studio.com/
 * License: http://amino-studio.com/license/
 */


module.exports = Backbone.Router.extend({
    routes: {
        "": "home"
    },
    initialize: function(options) {

    },
    home: function() {
        this.navigate(UT.sections.first().get('slug'), true);
    }
});
},{}],2:[function(require,module,exports){
var FieldModel = require('./../models/Field');

module.exports = Backbone.Collection.extend({
    model: FieldModel
});
},{"./../models/Field":24}],3:[function(require,module,exports){
var SectionModel = require('./../models/Section');

module.exports = Backbone.Collection.extend({
    model: SectionModel,

    initialize: function (items) {//, allItems, cls
        var me = this;

//        me.cls = cls;
//        me.allItems = allItems;

        _.bindAll(this, 'add');
    },

    setActive: function(selectSection) {
        var me = this;

        me.forEach(function(section) {
            if(section == selectSection) {
                var parent_id = section.get('parent_id');
                var id = section.get('id');
                if(parent_id > 0) {
                    var parentSection = me.where({ id: parent_id }).shift();
//                    parentSection.trigger('activateChild');
                    parentSection.set('showChilds', true);
                } else if(id > 0 && me.where({ parent_id: id }).length) {
//                    section.trigger('activateChild');
                    section.set('showChilds', true);
                }
                section.set('isActive', true);
                section.trigger('activate');
            } else {
                section.set('showChilds', false);
                section.set('isActive', false);
            }
        });
    }
}, {

    createFromJSON: function( data ) {
//        console.log(data);
//        return new this( _.where(data, {parent_id:0}), data, this );
        return new this( data );
    }
});
},{"./../models/Section":25}],4:[function(require,module,exports){
var TweakModel = require('./../models/Tweak');

module.exports = Backbone.Collection.extend({
    model: TweakModel
}, {

    createFromJSON: function(tweaks) {
        return new this(
            _.map(tweaks, function(tweak, tweak_ID) {
                return _.extend( tweak, { id: tweak_ID });
            })
        );
    }
});
},{"./../models/Tweak":26}],5:[function(require,module,exports){
var ValueModel = require('./../models/Value');

module.exports = Backbone.Collection.extend({
    model: ValueModel,
    isDirty: false,

    initialize: function( values, options) {
        var me = this;
    },

    getValue: function( key ) {
        var currentRole = UT.currentRole;
//        console.log(this.get(currentRole), currentRole, key, this.get(currentRole).get(key));
        return this.get(currentRole).get(key);
    },

    setValue: function( key, value ) {
        var currentRole = UT.currentRole,
            valueModel = this.get(currentRole);

        if(valueModel.get(key) == value) return;

        if( UT.debug ) console.log('set', key, value);

        if(!value) {
            valueModel.unset(key);
        } else {
            if(value == 1) { value = 1; }
            valueModel.set(key, value);
        }
    }
}, {
    createFromJSON: function(values, roles) {
        return new this(roles.map(function( role ) { return _.extend( values[role.id] || {}, { role: role.id }); }));
    }
});
},{"./../models/Value":27}],6:[function(require,module,exports){
/**
 * Created by Amino-Studio.
 * Url: http://amino-studio.com/
 * License: http://amino-studio.com/license/
 */

require('./vendor/jquery.mousewheel');
require('./vendor/jquery.cookie');
require('./vendor/jquery.storageapi');
require('./vendor/toastr');
require('./vendor/nprogress');

var router = require('./Router');
var AppView = require('./views/App');
var ValueCollection = require('./collections/Values');
var SectionCollection = require('./collections/Sections');
var TweakCollection = require('./collections/Tweaks');

//UT.values = { '':{ _post_min_word_count_amount:118, general_title_wptexturize_no:1 } };
if(UT.debug) console.log('LOADED VALUES', UT.values);

UT.currentRole = '';
UT.roles = new Backbone.Collection( UT.roles );
UT.values = ValueCollection.createFromJSON(UT.values, UT.roles);
console.log(Object.keys(UT.sections).length);
UT.sections = SectionCollection.createFromJSON(UT.sections);
//console.log(Object.keys(UT.tweaks).length);
UT.tweaks = TweakCollection.createFromJSON(UT.tweaks);
UT.tweak_groups = new Backbone.Collection(_.map(UT.tweak_groups, function(g, key) { g.id = key; return g; }));

Backbone.$(function() {
    var controller = new router();
    UT.app = new AppView({
        el: Backbone.$('#wpas_panel'),
        router: controller
    });

    Backbone.history.start();

    toastr.options.closeButton = true;
    toastr.options.newestOnTop = false;
    toastr.options.showMethod = 'slideDown';
    toastr.options.hideMethod = 'slideUp';
    toastr.options.preventDuplicates = true;

    NProgress.configure({ trickleRate: 0.02, trickleSpeed: 100, parent: '#wpas_panel .wpas_container' });
});

},{"./Router":1,"./collections/Sections":3,"./collections/Tweaks":4,"./collections/Values":5,"./vendor/jquery.cookie":28,"./vendor/jquery.mousewheel":29,"./vendor/jquery.storageapi":30,"./vendor/nprogress":31,"./vendor/toastr":32,"./views/App":33}],7:[function(require,module,exports){
var TextField = require('./../fields/Text');

module.exports = TextField.extend({
    itemTpl: _.template(
        '<label for="<%= id %>"><input type="checkbox" id="<%= id %>" class="checkbox" value="<%= key %>"> <%= label %></label>'
    ),

    events: {
        'change input': 'change'
    },


    render: function () {
        var me = this,
            options = me.model.get('options');

        me.$el.empty();

        Backbone.$.each(options, function(key, label) {
            var id = me.model.get('id') + '_' + key;
            me.$el.append(me.itemTpl({id:id,key: key,label:label}));
//            return false;
        });

        return this;
    },


    setValue: function( value ) {
        var me = this;

        _.each(value, function(enabled, key) {
            if(!enabled) return;
            me.$el.find('[value="'+key+'"]').prop('checked', true).trigger('change', true);
        });

        // TODO NEW FORMAT, ENABLE IN V 2.0
//        _.each(value, function(key) {
//            me.$el.find('[value="'+key+'"]').prop('checked', true).trigger('change', true);
//        });
    },

    change: function(ev, silent) {
        var me = this;

        if(silent) return;
        var selected = {};
        me.$el.find(':checked').each(function() {
            selected[this.value] = 1;
        });
//        console.log();
        me.trigger('change', me.model.id, selected);
    }
});


},{"./../fields/Text":21}],8:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<input class="wpas_field_input" />'
    ),

    events: {
        'change .wpas_field_input': 'change'
    },

    initialize: function (settings) {
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
        me.$el.html(me.tpl(me.model.attributes));
        me.$input = me.$el.find('.wpas_field_input');

        me.$input.wpColorPicker({
            palettes: true,
            change: function(event, ui){
                var color = ui.color.toCSS();
//                console.log(me.$input.val(), color);
                if(me.$input.val() == color) return;
                me.trigger('change', me.model.id, color);
            },
            clear: function(event, ui){
                me.trigger('change', me.model.id, false);
            }
        });

        return this;
    },

    setValue: function( value ) {
//        console.log(value);
        this.$input.val(value).trigger('change', true);
    },

    change: function(ev, silent) {
        var me = this;

        !silent && me.trigger('change', me.model.id, me.$input.val());
    }
});


},{}],9:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<label>Width</label><input class="wpas_field_width" type="number" />' +
        '<label>Height</label><input class="wpas_field_height" type="number" />'
    ),

    events: {
        'change .wpas_field_width': 'change',
        'change .wpas_field_height': 'change'
    },

    initialize: function (settings) {
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
        me.$el.html(me.tpl(me.model.attributes));
        me.$inputWidth = me.$el.find('.wpas_field_width');
        me.$inputHeight = me.$el.find('.wpas_field_height');

        return this;
    },

    setValue: function( value ) {
        this.$inputWidth.val(parseInt(value.width));
        this.$inputHeight.val(parseInt(value.height)).trigger('change', true);
    },

    change: function(ev, silent) {
        var me = this;

        !silent && me.trigger('change', me.model.id, {
            width: me.$inputWidth.val(),
            height: me.$inputHeight.val()
        });
    }
});


},{}],10:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<div class="wpas_field_info_body"><%= desc %></div>'
    ),

    events: {
        'change .wpas_field_input': 'change'
    },

    initialize: function (settings) {
        var me = this;

        settings.fieldBody.$container = settings.fieldBody.$el;
        settings.fieldBody.$container.empty();
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;

        me.$el.html(me.tpl(me.model.attributes));

        return this;
    },

    setValue: function( value ) {
    },

    change: function(ev, silent) {
    }
});


},{}],11:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<%= html %>'
    ),

    events: {},

    initialize: function (settings) {
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
        me.$el.html(me.tpl(me.model.attributes));

        return this;
    },

    setValue: function( value ) {

    },

    change: function(ev, silent) {

    }
});


},{}],12:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<div class="wpas_image"></div>' +
        '<a class="wpas_button wpas_button_upload left">Upload</a>' +
        '<a class="wpas_button wpas_button_select left">Select</a>' +
        '<a class="wpas_button wpas_button_url left">URL</a>' +
        '<a class="wpas_button wpas_button_clear left">Clear</a>'
    ),

    events: {
        'click .wpas_button_upload': 'upload',
        'click .wpas_button_select': 'select',
        'click .wpas_button_url': 'url',
        'click .wpas_button_clear': 'clear'
    },

    initialize: function (settings) {
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
        me.$el.html(me.tpl(me.model.attributes));
        me.$image = me.$el.find('.wpas_image');
        me.$uploadButton = me.$el.find('.wpas_button_upload');
        me.$clearButton = me.$el.find('.wpas_button_clear');
        me.$clearButton.hide();
        return this;
    },

    select: function(ev) {
        this.upload(ev, true);
    },

    upload: function(ev, uploadTab) {
        var me = this;

        var dialog = me['frame' + (uploadTab?'upload':'select')];
        wp.media.controller.Library.prototype.defaults.contentUserSetting = uploadTab;

        if ( dialog ) {
//            console.log('reopen');
            dialog.open();
            return;
        }

        dialog = wp.media({
            title: 'Select Image',
            button: {
                text: 'Select'
            },
            library: { type: 'image' },
            multiple: false
        });

        dialog.on( 'select', function(ev) {
            var attachment = dialog.state().get('selection').first().toJSON();
            var data = {
                id: attachment.id,
//                filename: attachment.filename,
                url: attachment.url
            };
            if(attachment.sizes.full) {
                data.width = attachment.sizes.full.width;
                data.height = attachment.sizes.full.height;

                if(!attachment.sizes.thumbnail) attachment.sizes.thumbnail = attachment.sizes.full;
            }
            if(attachment.sizes.thumbnail) {
                data.thumbnail = attachment.sizes.thumbnail.url;
            }

            me.change(ev, false, data);
            me.setValue(data);
        });

        dialog.open();

        me['frame' + (uploadTab?'upload':'select')] = dialog;
    },

    url: function(ev) {
        var me = this,
            value = UT.values.getValue(me.model.id);
        var url = prompt('Please, enter url of your image...', value?value.url:'');

        if(url) {
            var data = {
                id:null,
                url: url,
                thumbnail: url
            };
            me.change(ev, false, data);
            me.setValue(data);
        }
    },

    clear: function(ev) {
        var me = this;

        me.setValue(false);
        me.change(ev, false, false);
    },

    setValue: function( value ) {
        var me = this;

        me.$image.empty().hide();

        if(value && _.isObject(value)) {
            me.$image.append( Backbone.$('<img/>', { src: value.thumbnail }) ).show();
            me.$clearButton.show();
        } else {
            me.$clearButton.hide();
        }

//        me.$image.trigger('change', true);
    },

    change: function(ev, silent, attachment) {
        var me = this;

//        console.log(attachment);
        !silent && me.trigger('change', me.model.id, attachment);
    }
});


},{}],13:[function(require,module,exports){
module.exports = Backbone.View.extend({
    itemTpl: _.template(
        '<label for="<%= id %>"><input type="checkbox" id="<%= id %>" class="checkbox" value="<%= key %>"> <%= label %></label>'
    ),

    events: {
        'change input': 'change'
    },


    render: function () {
        var me = this,
            $ = Backbone.$,
            options = me.model.get('options'),
            postType = me.model.get('post_type');

        me.$el.addClass('wpas_field_checkbox');
        me.$el.empty();

        $.ajax({
            type      : 'post',
            url       : me.model.get('post_url') + '?post_type=' + postType,
            data      : {
                action     : 'ut_metabox_hide_get',
                _ajax_nonce: me.model.get('nonce')
            },
            beforeSend: function () {
                me.$el.html('<div class="ut_spinner" role="spinner"><div class="spinner-icon"></div></div>');
            },
            success   : function (data) {
                me.$el.empty();

                if (data && data.meta_boxes) {
                    _.each(data.meta_boxes, function(box) {
                        box.id = me.model.id + '_' + postType + '_' + box.key;
                        me.$el.append( me.itemTpl(box) );
                    });

                    var values = UT.values.getValue(me.model.id);
                    _.each(values, function(selected, key) {
                        me.$el.find('[value="'+key+'"]').prop('checked', true);
                    });
                }
            }
        });

        return this;
    },


    setValue: function( value ) {
        var me = this;
        if(!value && !_.isObject(value)) return;

        me.$el.find('[type="checkbox"]').prop('checked', false);
        _.each(value, function(selected, key) {
            me.$el.find('[value="'+key+'"]').prop('checked', true);
        });
//        console.log(value);
    },

    change: function(ev, silent) {
        var me = this;

        if(silent) return;
        var selected = {};
        me.$el.find(':checked').each(function() {
            selected[this.value] = 1;
        });

        me.trigger('change', me.model.id, selected);
    }
});


},{}],14:[function(require,module,exports){
var TextField = require('./../fields/Text');

module.exports = TextField.extend({
    itemTpl: _.template(
        '<label for="<%= id %>"><input type="radio" id="<%= id %>" name="<%= key %>" class="checkbox" value="<%= value %>"> <%= label %></label>'
    ),

    events: {
        'change input': 'change'
    },


    render: function () {
        var me = this,
            options = me.model.get('options');

        me.$el.empty();

        Backbone.$.each(options, function(key, label) {
//            console.log(me.model.id, key, label);
            var id = me.model.get('id') + '_' + key;
            me.$el.append(me.itemTpl({key:me.model.id, id:id, value:key, label:label}));
//            return false;
        });

        return this;
    },

    setValue: function( value ) {
        this.$el.find('[value="'+value+'"]').prop('checked', true).trigger('change', true);
    },

    change: function(ev, silent) {
        var me = this;

        !silent && me.trigger('change', me.model.id, me.$el.find(':checked').val());
    }
});


},{"./../fields/Text":21}],15:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl      : _.template(
        '<div class="wpas_field_info_body"><%= content %></div>'
    ),

    events: {
        'change .wpas_field_input': 'change'
    },

    initialize: function (settings) {
        var me = this;

        settings.fieldBody.$container = settings.fieldBody.$el;
        settings.fieldBody.$container.empty();
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
//        console.log(me.model.attributes);
        me.$el.html(me.tpl(me.model.attributes));

        return this;
    },

    setValue: function (value) {
    },
    change  : function (ev, silent) {
    }
});


},{}],16:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<div class="wpas_field_info_body"><%= title %></div>'
    ),

    events: {
        'change .wpas_field_input': 'change'
    },

    initialize: function (settings) {
        var me = this;

        settings.fieldBody.$container = settings.fieldBody.$el;
        settings.fieldBody.$container.empty();
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;

        me.$el.html(me.tpl(me.model.attributes));

        return this;
    },

    setValue: function( value ) {
    },

    change: function(ev, silent) {
    }
});


},{}],17:[function(require,module,exports){
var TextField = require('./../fields/Text');

module.exports = TextField.extend({
    selectTpl: _.template(
        '<select>' +
//            '<option style="color: #ccc;"><i>'+'None'+'</i></option>' +
            '<% _.each(options, function(v, k) { %>' +
                '<option value="<%= k %>" <%= value == k ? \'selected\' : void 0 %>><%= v %></option>' +
            '<% }); %>' +
        '</select>'
    ),

    events: {
        'change select': 'change'
    },


    render: function () {
        var me = this,
            value,
            options = me.model.get('options');

//        console.log(me.model.attributes);
        me.$el.empty();
        me.$el.append(me.selectTpl({ options: options, value: value }));
        me.$select = me.$el.find('select');
        me.$select.select2({
//            triggerChange: true,
            placeholder:'None',
            allowClear: true,
            closeOnSelect: !me.model.get('multi'),
            multiple: me.model.get('multi'),
            minimumResultsForSearch: -1,
//            theme: 'ut2',
//            width: 'resolve'
            width: 300
        });
        return this;
    },

    setValue: function( value ) {
        var me = this;
        if(!value) value = '';

        me.$select.val(value).trigger('change', true);
    },

    change: function(ev, silent) {
        var me = this;

        if(silent) return;

        me.trigger('change', me.model.id, me.$select.val());
    }
});


},{"./../fields/Text":21}],18:[function(require,module,exports){
var TextField = require('./../fields/Text');

module.exports = TextField.extend({
    tpl: _.template(
        '<input class="wpas_field_input"/>' +
        '<a class="wpas_field_slider_steper wpas_field_slider_up" tabindex="-1" data-step="1"><span>▲</span></a>' +
        '<a class="wpas_field_slider_steper wpas_field_slider_down" tabindex="-1" data-step="-1"><span>▼</span></a>'
    ),

    events: {
        'change .wpas_field_input'           : 'change',
        'mousedown .wpas_field_slider_steper': 'mouseDown',
        'mouseup .wpas_field_slider_steper'  : 'mouseUp',
        'mousewheel .wpas_field_input'       : 'mousewheel'
    },

    initialize: function () {
        var me = this;
        me.timerDelay = 250;
    },

    render: function () {
        var me = this;

        me.$el.html(me.tpl(me.model.attributes));
        me.$input = me.$el.find('.wpas_field_input');

        return this;
    },

    ////////////
    mousewheel: function(ev) {
        var me = this;

        ev.preventDefault();
        me.increase(ev.deltaY);//, ev.deltaFactor
    },

    mouseDown: function (ev) {
        var me = this,
            $el = Backbone.$(ev.target),
            step = 1;

        me.timer && clearTimeout(me.timer);

        if(!$el.is('.wpas_field_slider_steper')) $el = $el.closest('.wpas_field_slider_steper');
        step = parseInt($el.data('step'));

        me.increase(step);

        var r = function () {
            me.timer = setTimeout(function () {
                if (!me.timer) return;
                if (me.timerDelay > 30) me.timerDelay /= 1.2;
                me.increase(step);
                r();
            }, me.timerDelay);
        };
        r();
    },

    mouseUp: function () {
        var me = this;
        me.timer && clearTimeout(me.timer);
        me.timerDelay = 250;
    },

    increase: function (step) {
        var me = this,
            value = parseInt(me.$input.val()),
            min = me.model.get('min'),
            max = me.model.get('max');

        step = step || 1;
        if(!value) value = 0;
        value = value + step * me.model.get('step');
        if(value !== null && value > max) value = max;
        if(value !== null && value < min) value = min;

        me.$input.val(value).trigger('change');
    }
});


},{"./../fields/Text":21}],19:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<label>Left</label><input class="wpas_field_left" type="number" />' +
        '<label>Right</label><input class="wpas_field_right" type="number" />' +
        '<label>Top</label><input class="wpas_field_top" type="number" />' +
        '<label>Bottom</label><input class="wpas_field_bottom" type="number" />'
    ),

//    tpl: _.template(
//        '<label>Left</label><input class="wpas_field_left" type="number" />' +
//        '<div class="top_bottom">' +
//        '<div><label>Top</label><input class="wpas_field_top" type="number" /></div>' +
//        '<div><label>Bottom</label><input class="wpas_field_bottom" type="number" /></div>' +
//        '</div>' +
//        '<label>Right</label><input class="wpas_field_right" type="number" />'
//    ),

    events: {
        'change .wpas_field_left': 'change',
        'change .wpas_field_right': 'change',
        'change .wpas_field_top': 'change',
        'change .wpas_field_bottom': 'change'
    },

    initialize: function (settings) {
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
        me.$el.html(me.tpl(me.model.attributes));
        me.$inputLeft = me.$el.find('.wpas_field_left');
        me.$inputRight = me.$el.find('.wpas_field_right');
        me.$inputTop = me.$el.find('.wpas_field_top');
        me.$inputBottom = me.$el.find('.wpas_field_bottom');

        return this;
    },

    setValue: function( value ) {
        this.$inputLeft.val(parseInt(value['padding-left']));
        this.$inputRight.val(parseInt(value['padding-right']));
        this.$inputTop.val(parseInt(value['padding-top']));
        this.$inputBottom.val(parseInt(value['padding-bottom'])).trigger('change', true);
    },

    change: function(ev, silent) {
        var me = this;

        !silent && me.trigger('change', me.model.id, {
            'padding-left': me.$inputLeft.val(),
            'padding-right': me.$inputRight.val(),
            'padding-top': me.$inputTop.val(),
            'padding-bottom': me.$inputBottom.val()
        });
    }
});


},{}],20:[function(require,module,exports){
var TextField = require('./../fields/Text');

module.exports = TextField.extend({
    tpl: _.template(
        '<span class="switchery"><small></small></span>' +
        '<% if (typeof(on_desc) !== "undefined" && on_desc) { %>' +
            '<div class="wpas_field_on_desc"><%= on_desc %></div>' +
        '<% } %>' +
        '<% if (typeof(off_desc) !== "undefined" && off_desc) { %>' +
            '<div class="wpas_field_off_desc"><%= off_desc %></div>' +
        '<% } %>'
    ),


    events: {
        'click .switchery': 'click'
//        'click .switchery small': 'click'
    },


    initialize: function () {
        var me = this;
        !me.model.get('off_desc') && me.model.set('off_desc', 'Off');
        !me.model.get('on_desc') && me.model.set('on_desc', 'On');
    },

    render: function () {
        var me = this;

        me.$el.html(me.tpl(me.model.attributes));
        me.$span = me.$el.find('.switchery');
        me.$onDesc = me.$el.find('.wpas_field_on_desc');
        me.$offDesc = me.$el.find('.wpas_field_off_desc');
        return this;
    },

    setValue: function(value) {
        var me = this;
        me.$span.toggleClass('checked', !!value);
        me.change(true);
    },

    click: function(ev, silent) {
        var me = this;

        me.$span.toggleClass('checked');
        me.change(false);
    },

    change: function(silent) {
        var me = this;

        var checked = me.$span.hasClass('checked');

        me.$onDesc.toggleClass('show', checked);
        me.$offDesc.toggleClass('show', !checked);

        !silent && me.trigger('change', me.model.id, checked);
    }
});


},{"./../fields/Text":21}],21:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<input class="wpas_field_input" />'
    ),

    events: {
        'change .wpas_field_input': 'change',
        'keyup .wpas_field_input': 'change'
    },

    initialize: function (settings) {
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
        me.$el.html(me.tpl(me.model.attributes));
        me.$input = me.$el.find('.wpas_field_input');
        if(me.model.get('placeholder')) me.$input.prop('placeholder', me.model.get('placeholder'));

        return this;
    },

    setValue: function( value ) {
        if(_.isObject(value)) value = JSON.stringify(value);
        this.$input.val(value).trigger('change', true);
    },

    change: function(ev, silent) {
        var me = this;

        !silent && me.trigger('change', me.model.id, me.$input.val());
    }
});


},{}],22:[function(require,module,exports){
var TextField = require('./../fields/Text');

module.exports = TextField.extend({
    tpl: _.template(
        '<textarea></textarea>'
    ),

    events: {
        'change textarea': 'change',
        'keyup textarea': 'change'
    },


    render: function () {
        var me = this;

        me.$el.html(me.tpl(me.model.attributes));
        me.$input = me.$el.find('textarea');

        if(me.model.get('placeholder')) me.$input.prop('placeholder', me.model.get('placeholder'));

        return this;
    }
});


},{"./../fields/Text":21}],23:[function(require,module,exports){
module.exports = Backbone.View.extend({
    className: 'wpas_field_div',
    tpl: _.template(
        '<div class="lines"></div>' +
        '<a class="add_more wpas_button left">Add More</a>'
    ),

    lineTpl: _.template(
        '<div class="line">' +
            '<input class="from" value="<%= b %>" />' +
            '<span> to </span>' +
            '<input class="to" value="<%= a %>" />' +
            '<a class="remove" href="javascript:void(0)">Remove</a>' +
        '</div>'
    ),

    events: {
        'click .add_more': 'add',
        'change input': 'change',
        'keyup input': 'change',
        'click .remove': 'remove'
    },

    initialize: function (settings) {
//        this.listenTo(this.model, "change", this.render);
    },

    render: function () {
        var me = this;
        me.$el.html(me.tpl(me.model.attributes));
        me.$lines = me.$el.find('.lines');

        return this;
    },

    add: function() {
        var me = this,
            $ = Backbone.$;

        var html = $(me.lineTpl({a:'',b:''}));
        me.$lines.append( html );
        html.find('.from').focus();
    },

    remove: function(e) {
        e.preventDefault();
        var me = this,
            $ = Backbone.$,
            $el = $(e.currentTarget).closest('.line');

        $el.remove();

        me.change(e);
    },

    setValue: function( value ) {
        var me = this;

        me.$lines.empty();

        _.each(value, function(line) {
            me.$lines.append( me.lineTpl(line) );
//            console.log(line);
        });
        this.trigger('change', true);
    },

    change: function(ev, silent) {
        var me = this,
            $ = Backbone.$;

        if(silent) return;

        var data = [];
        me.$lines.find('.line').each(function() {
            var $line = $(this),
                $from = $line.find('.from').val(),
                $to = $line.find('.to').val();

            data.push( { b: $from, a: $to } );

        });
        me.trigger('change', me.model.id, data);
    }
});


},{}],24:[function(require,module,exports){
var FieldView = require('./../views/Field');

module.exports = Backbone.Model.extend({
    defaults: {
        id: null,
//        multi: false,
        title: '',
        'default':''
    },

    getView: function(settings){
        var me = this;

        me.view && me.view.remove();

//        if(!me.view) {
            me.view = new FieldView(_.extend(settings, {model: me }));
            me.view.render();
//        }

        return me.view;
    }
});
},{"./../views/Field":34}],25:[function(require,module,exports){
var TweakCollection = require('./../collections/Tweaks');

module.exports = Backbone.Model.extend({
    idAttribute:'_id',
    defaults: {
        slug: null,
        title: '',
        id: null,
        parent_id: 0,
        isActive: false,
        isHidden: false,
        showChilds: false
    },


    initialize: function () {
        var me = this,
            id = me.get('id');
//            childs = [];

//        _.bindAll(me, 'haveChilds');
//        me.childs = new (me.collection.cls)(childs, me.collection.allItems, me.collection.cls);
    },

    haveChilds: function() {
        var me = this,
            id = me.get('id');

        var isHave = false;
        if( id > 0 ) {
            isHave = me.collection.where({ parent_id: id }).length;
        }

        return isHave;
    },

    getTweaks: function() {
        var me = this;
        var tweaks = me.get('tweaks');

        tweaks = _.map(tweaks, function(id) { return UT.tweaks.get(id); }, UT.tweaks);
        return new TweakCollection(tweaks);
    }
});
},{"./../collections/Tweaks":4}],26:[function(require,module,exports){
var FieldsCollection = require('./../collections/Fields');
//var FieldModel = require('./../models/Field');

module.exports = Backbone.Model.extend({
    defaults: {
        id: null,
        title: null,
        group:'',
        fields: []
    },

    initialize: function() {
        var me = this;

        me.set('fields', new FieldsCollection( me.get('fields') ));
    },

    getFields: function() {
        return this.get('fields');
    }
});
},{"./../collections/Fields":2}],27:[function(require,module,exports){
module.exports = Backbone.Model.extend({
    idAttribute: 'role'
});
},{}],28:[function(require,module,exports){
/*!
 * jQuery Cookie Plugin v1.4.1
 * https://github.com/carhartl/jquery-cookie
 *
 * Copyright 2006, 2014 Klaus Hartl
 * Released under the MIT license
 */
(function ($) {

    var pluses = /\+/g;

    function encode(s) {
        return config.raw ? s : encodeURIComponent(s);
    }

    function decode(s) {
        return config.raw ? s : decodeURIComponent(s);
    }

    function stringifyCookieValue(value) {
        return encode(config.json ? JSON.stringify(value) : String(value));
    }

    function parseCookieValue(s) {
        if (s.indexOf('"') === 0) {
            // This is a quoted cookie as according to RFC2068, unescape...
            s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
        }

        try {
            // Replace server-side written pluses with spaces.
            // If we can't decode the cookie, ignore it, it's unusable.
            // If we can't parse the cookie, ignore it, it's unusable.
            s = decodeURIComponent(s.replace(pluses, ' '));
            return config.json ? JSON.parse(s) : s;
        } catch(e) {}
    }

    function read(s, converter) {
        var value = config.raw ? s : parseCookieValue(s);
        return $.isFunction(converter) ? converter(value) : value;
    }

    var config = $.cookie = function (key, value, options) {

        // Write

        if (arguments.length > 1 && !$.isFunction(value)) {
            options = $.extend({}, config.defaults, options);

            if (typeof options.expires === 'number') {
                var days = options.expires, t = options.expires = new Date();
                t.setTime(+t + days * 864e+5);
            }

            return (document.cookie = [
                encode(key), '=', stringifyCookieValue(value),
                options.expires ? '; expires=' + options.expires.toUTCString() : '', // use expires attribute, max-age is not supported by IE
                options.path    ? '; path=' + options.path : '',
                options.domain  ? '; domain=' + options.domain : '',
                options.secure  ? '; secure' : ''
            ].join(''));
        }

        // Read

        var result = key ? undefined : {};

        // To prevent the for loop in the first place assign an empty array
        // in case there are no cookies at all. Also prevents odd result when
        // calling $.cookie().
        var cookies = document.cookie ? document.cookie.split('; ') : [];

        for (var i = 0, l = cookies.length; i < l; i++) {
            var parts = cookies[i].split('=');
            var name = decode(parts.shift());
            var cookie = parts.join('=');

            if (key && key === name) {
                // If second argument (value) is a function it's a converter...
                result = read(cookie, value);
                break;
            }

            // Prevent storing a cookie that we couldn't decode.
            if (!key && (cookie = read(cookie)) !== undefined) {
                result[name] = cookie;
            }
        }

        return result;
    };

    config.defaults = {};

    $.removeCookie = function (key, options) {
        if ($.cookie(key) === undefined) {
            return false;
        }

        // Must not alter options, thus extending a fresh object...
        $.cookie(key, '', $.extend({}, options, { expires: -1 }));
        return !$.cookie(key);
    };

})(jQuery);
},{}],29:[function(require,module,exports){
/*!
 * jQuery Mousewheel 3.1.12
 *
 * Copyright 2014 jQuery Foundation and other contributors
 * Released under the MIT license.
 * http://jquery.org/license
 */
(function ($) {
    var toFix  = ['wheel', 'mousewheel', 'DOMMouseScroll', 'MozMousePixelScroll'],
        toBind = ( 'onwheel' in document || document.documentMode >= 9 ) ?
            ['wheel'] : ['mousewheel', 'DomMouseScroll', 'MozMousePixelScroll'],
        slice  = Array.prototype.slice,
        nullLowestDeltaTimeout, lowestDelta;

    if ( $.event.fixHooks ) {
        for ( var i = toFix.length; i; ) {
            $.event.fixHooks[ toFix[--i] ] = $.event.mouseHooks;
        }
    }

    var special = $.event.special.mousewheel = {
        version: '3.1.12',

        setup: function() {
            if ( this.addEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.addEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = handler;
            }
            // Store the line height and page height for this particular element
            $.data(this, 'mousewheel-line-height', special.getLineHeight(this));
            $.data(this, 'mousewheel-page-height', special.getPageHeight(this));
        },

        teardown: function() {
            if ( this.removeEventListener ) {
                for ( var i = toBind.length; i; ) {
                    this.removeEventListener( toBind[--i], handler, false );
                }
            } else {
                this.onmousewheel = null;
            }
            // Clean up the data we added to the element
            $.removeData(this, 'mousewheel-line-height');
            $.removeData(this, 'mousewheel-page-height');
        },

        getLineHeight: function(elem) {
            var $elem = $(elem),
                $parent = $elem['offsetParent' in $.fn ? 'offsetParent' : 'parent']();
            if (!$parent.length) {
                $parent = $('body');
            }
            return parseInt($parent.css('fontSize'), 10) || parseInt($elem.css('fontSize'), 10) || 16;
        },

        getPageHeight: function(elem) {
            return $(elem).height();
        },

        settings: {
            adjustOldDeltas: true, // see shouldAdjustOldDeltas() below
            normalizeOffset: true  // calls getBoundingClientRect for each event
        }
    };

    $.fn.extend({
        mousewheel: function(fn) {
            return fn ? this.bind('mousewheel', fn) : this.trigger('mousewheel');
        },

        unmousewheel: function(fn) {
            return this.unbind('mousewheel', fn);
        }
    });


    function handler(event) {
        var orgEvent   = event || window.event,
            args       = slice.call(arguments, 1),
            delta      = 0,
            deltaX     = 0,
            deltaY     = 0,
            absDelta   = 0,
            offsetX    = 0,
            offsetY    = 0;
        event = $.event.fix(orgEvent);
        event.type = 'mousewheel';

        // Old school scrollwheel delta
        if ( 'detail'      in orgEvent ) { deltaY = orgEvent.detail * -1;      }
        if ( 'wheelDelta'  in orgEvent ) { deltaY = orgEvent.wheelDelta;       }
        if ( 'wheelDeltaY' in orgEvent ) { deltaY = orgEvent.wheelDeltaY;      }
        if ( 'wheelDeltaX' in orgEvent ) { deltaX = orgEvent.wheelDeltaX * -1; }

        // Firefox < 17 horizontal scrolling related to DOMMouseScroll event
        if ( 'axis' in orgEvent && orgEvent.axis === orgEvent.HORIZONTAL_AXIS ) {
            deltaX = deltaY * -1;
            deltaY = 0;
        }

        // Set delta to be deltaY or deltaX if deltaY is 0 for backwards compatabilitiy
        delta = deltaY === 0 ? deltaX : deltaY;

        // New school wheel delta (wheel event)
        if ( 'deltaY' in orgEvent ) {
            deltaY = orgEvent.deltaY * -1;
            delta  = deltaY;
        }
        if ( 'deltaX' in orgEvent ) {
            deltaX = orgEvent.deltaX;
            if ( deltaY === 0 ) { delta  = deltaX * -1; }
        }

        // No change actually happened, no reason to go any further
        if ( deltaY === 0 && deltaX === 0 ) { return; }

        // Need to convert lines and pages to pixels if we aren't already in pixels
        // There are three delta modes:
        //   * deltaMode 0 is by pixels, nothing to do
        //   * deltaMode 1 is by lines
        //   * deltaMode 2 is by pages
        if ( orgEvent.deltaMode === 1 ) {
            var lineHeight = $.data(this, 'mousewheel-line-height');
            delta  *= lineHeight;
            deltaY *= lineHeight;
            deltaX *= lineHeight;
        } else if ( orgEvent.deltaMode === 2 ) {
            var pageHeight = $.data(this, 'mousewheel-page-height');
            delta  *= pageHeight;
            deltaY *= pageHeight;
            deltaX *= pageHeight;
        }

        // Store lowest absolute delta to normalize the delta values
        absDelta = Math.max( Math.abs(deltaY), Math.abs(deltaX) );

        if ( !lowestDelta || absDelta < lowestDelta ) {
            lowestDelta = absDelta;

            // Adjust older deltas if necessary
            if ( shouldAdjustOldDeltas(orgEvent, absDelta) ) {
                lowestDelta /= 40;
            }
        }

        // Adjust older deltas if necessary
        if ( shouldAdjustOldDeltas(orgEvent, absDelta) ) {
            // Divide all the things by 40!
            delta  /= 40;
            deltaX /= 40;
            deltaY /= 40;
        }

        // Get a whole, normalized value for the deltas
        delta  = Math[ delta  >= 1 ? 'floor' : 'ceil' ](delta  / lowestDelta);
        deltaX = Math[ deltaX >= 1 ? 'floor' : 'ceil' ](deltaX / lowestDelta);
        deltaY = Math[ deltaY >= 1 ? 'floor' : 'ceil' ](deltaY / lowestDelta);

        // Normalise offsetX and offsetY properties
        if ( special.settings.normalizeOffset && this.getBoundingClientRect ) {
            var boundingRect = this.getBoundingClientRect();
            offsetX = event.clientX - boundingRect.left;
            offsetY = event.clientY - boundingRect.top;
        }

        // Add information to the event object
        event.deltaX = deltaX;
        event.deltaY = deltaY;
        event.deltaFactor = lowestDelta;
        event.offsetX = offsetX;
        event.offsetY = offsetY;
        // Go ahead and set deltaMode to 0 since we converted to pixels
        // Although this is a little odd since we overwrite the deltaX/Y
        // properties with normalized deltas.
        event.deltaMode = 0;

        // Add event and delta to the front of the arguments
        args.unshift(event, delta, deltaX, deltaY);

        // Clearout lowestDelta after sometime to better
        // handle multiple device types that give different
        // a different lowestDelta
        // Ex: trackpad = 3 and mouse wheel = 120
        if (nullLowestDeltaTimeout) { clearTimeout(nullLowestDeltaTimeout); }
        nullLowestDeltaTimeout = setTimeout(nullLowestDelta, 200);

        return ($.event.dispatch || $.event.handle).apply(this, args);
    }

    function nullLowestDelta() {
        lowestDelta = null;
    }

    function shouldAdjustOldDeltas(orgEvent, absDelta) {
        // If this is an older event and the delta is divisable by 120,
        // then we are assuming that the browser is treating this as an
        // older mouse wheel event and that we should divide the deltas
        // by 40 to try and get a more usable deltaFactor.
        // Side note, this actually impacts the reported scroll distance
        // in older browsers and can cause scrolling to be slower than native.
        // Turn this off by setting $.event.special.mousewheel.settings.adjustOldDeltas to false.
        return special.settings.adjustOldDeltas && orgEvent.type === 'mousewheel' && absDelta % 120 === 0;
    }

})(jQuery);
},{}],30:[function(require,module,exports){
/*
 * jQuery Storage API Plugin
 *
 * Copyright (c) 2013 Julien Maurel
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 * https://github.com/julien-maurel/jQuery-Storage-API
 *
 * Version: 1.7.3
 *
 */
(function($){
    // Prefix to use with cookie fallback
    var cookie_local_prefix="ls_";
    var cookie_session_prefix="ss_";

    // Get items from a storage
    function _get(storage){
        var l=arguments.length,s=window[storage],a=arguments,a1=a[1],vi,ret,tmp;
        if(l<2) throw new Error('Minimum 2 arguments must be given');
        else if($.isArray(a1)){
            // If second argument is an array, return an object with value of storage for each item in this array
            ret={};
            for(var i in a1){
                vi=a1[i];
                try{
                    ret[vi]=JSON.parse(s.getItem(vi));
                }catch(e){
                    ret[vi]=s.getItem(vi);
                }
            }
            return ret;
        }else if(l==2){
            // If only 2 arguments, return value directly
            try{
                return JSON.parse(s.getItem(a1));
            }catch(e){
                return s.getItem(a1);
            }
        }else{
            // If more than 2 arguments, parse storage to retrieve final value to return it
            // Get first level
            try{
                ret=JSON.parse(s.getItem(a1));
            }catch(e){
                throw new ReferenceError(a1+' is not defined in this storage');
            }
            // Parse next levels
            for(var i=2;i<l-1;i++){
                ret=ret[a[i]];
                if(ret===undefined) throw new ReferenceError([].slice.call(a,1,i+1).join('.')+' is not defined in this storage');
            }
            // If last argument is an array, return an object with value for each item in this array
            // Else return value normally
            if($.isArray(a[i])){
                tmp=ret;
                ret={};
                for(var j in a[i]){
                    ret[a[i][j]]=tmp[a[i][j]];
                }
                return ret;
            }else{
                return ret[a[i]];
            }
        }
    }

    // Set items of a storage
    function _set(storage){
        var l=arguments.length,s=window[storage],a=arguments,a1=a[1],a2=a[2],vi,to_store={},tmp;
        if(l<2 || !$.isPlainObject(a1) && l<3) throw new Error('Minimum 3 arguments must be given or second parameter must be an object');
        else if($.isPlainObject(a1)){
            // If first argument is an object, set values of storage for each property of this object
            for(var i in a1){
                vi=a1[i];
                if(!$.isPlainObject(vi)) s.setItem(i,vi);
                else s.setItem(i,JSON.stringify(vi));
            }
            return a1;
        }else if(l==3){
            // If only 3 arguments, set value of storage directly
            if(typeof a2==='object') s.setItem(a1,JSON.stringify(a2));
            else s.setItem(a1,a2);
            return a2;
        }else{
            // If more than 3 arguments, parse storage to retrieve final node and set value
            // Get first level
            try{
                tmp=s.getItem(a1);
                if(tmp!=null) {
                    to_store=JSON.parse(tmp);
                }
            }catch(e){
            }
            tmp=to_store;
            // Parse next levels and set value
            for(var i=2;i<l-2;i++){
                vi=a[i];
                if(!tmp[vi] || !$.isPlainObject(tmp[vi])) tmp[vi]={};
                tmp=tmp[vi];
            }
            tmp[a[i]]=a[i+1];
            s.setItem(a1,JSON.stringify(to_store));
            return to_store;
        }
    }

    // Remove items from a storage
    function _remove(storage){
        var l=arguments.length,s=window[storage],a=arguments,a1=a[1],to_store,tmp;
        if(l<2) throw new Error('Minimum 2 arguments must be given');
        else if($.isArray(a1)){
            // If first argument is an array, remove values from storage for each item of this array
            for(var i in a1){
                s.removeItem(a1[i]);
            }
            return true;
        }else if(l==2){
            // If only 2 arguments, remove value from storage directly
            s.removeItem(a1);
            return true;
        }else{
            // If more than 2 arguments, parse storage to retrieve final node and remove value
            // Get first level
            try{
                to_store=tmp=JSON.parse(s.getItem(a1));
            }catch(e){
                throw new ReferenceError(a1+' is not defined in this storage');
            }
            // Parse next levels and remove value
            for(var i=2;i<l-1;i++){
                tmp=tmp[a[i]];
                if(tmp===undefined) throw new ReferenceError([].slice.call(a,1,i).join('.')+' is not defined in this storage');
            }
            // If last argument is an array,remove value for each item in this array
            // Else remove value normally
            if($.isArray(a[i])){
                for(var j in a[i]){
                    delete tmp[a[i][j]];
                }
            }else{
                delete tmp[a[i]];
            }
            s.setItem(a1,JSON.stringify(to_store));
            return true;
        }
    }

    // Remove all items from a storage
    function _removeAll(storage, reinit_ns){
        var keys=_keys(storage);
        for(var i in keys){
            _remove(storage,keys[i]);
        }
        // Reinitialize all namespace storages
        if(reinit_ns){
            for(var i in $.namespaceStorages){
                _createNamespace(i);
            }
        }
    }

    // Check if items of a storage are empty
    function _isEmpty(storage){
        var l=arguments.length,a=arguments,s=window[storage],a1=a[1];
        if(l==1){
            // If only one argument, test if storage is empty
            return (_keys(storage).length==0);
        }else if($.isArray(a1)){
            // If first argument is an array, test each item of this array and return true only if all items are empty
            for(var i=0; i<a1.length;i++){
                if(!_isEmpty(storage,a1[i])) return false;
            }
            return true;
        }else{
            // If more than 1 argument, try to get value and test it
            try{
                var v=_get.apply(this, arguments);
                // Convert result to an object (if last argument is an array, _get return already an object) and test each item
                if(!$.isArray(a[l-1])) v={'totest':v};
                for(var i in v){
                    if(!(
                        ($.isPlainObject(v[i]) && $.isEmptyObject(v[i])) ||
                        ($.isArray(v[i]) && !v[i].length) ||
                        (!v[i])
                        )) return false;
                }
                return true;
            }catch(e){
                return true;
            }
        }
    }

    // Check if items of a storage exist
    function _isSet(storage){
        var l=arguments.length,a=arguments,s=window[storage],a1=a[1];
        if(l<2) throw new Error('Minimum 2 arguments must be given');
        if($.isArray(a1)){
            // If first argument is an array, test each item of this array and return true only if all items exist
            for(var i=0; i<a1.length;i++){
                if(!_isSet(storage,a1[i])) return false;
            }
            return true;
        }else{
            // For other case, try to get value and test it
            try{
                var v=_get.apply(this, arguments);
                // Convert result to an object (if last argument is an array, _get return already an object) and test each item
                if(!$.isArray(a[l-1])) v={'totest':v};
                for(var i in v){
                    if(!(v[i]!==undefined && v[i]!==null)) return false;
                }
                return true;
            }catch(e){
                return false;
            }
        }
    }

    // Get keys of a storage or of an item of the storage
    function _keys(storage){
        var l=arguments.length,s=window[storage],a=arguments,a1=a[1],keys=[],o={};
        // If more than 1 argument, get value from storage to retrieve keys
        // Else, use storage to retrieve keys
        if(l>1){
            o=_get.apply(this,a);
        }else{
            o=s;
        }
        if(o._cookie){
            // If storage is a cookie, use $.cookie to retrieve keys
            for(var key in $.cookie()){
                if(key!='') {
                    keys.push(key.replace(o._prefix,''));
                }
            }
        }else{
            for(var i in o){
                keys.push(i);
            }
        }
        return keys;
    }

    // Create new namespace storage
    function _createNamespace(name){
        if(!name || typeof name!="string") throw new Error('First parameter must be a string');
        if(storage_available){
            if(!window.localStorage.getItem(name)) window.localStorage.setItem(name,'{}');
            if(!window.sessionStorage.getItem(name)) window.sessionStorage.setItem(name,'{}');
        }else{
            if(!window.localCookieStorage.getItem(name)) window.localCookieStorage.setItem(name,'{}');
            if(!window.sessionCookieStorage.getItem(name)) window.sessionCookieStorage.setItem(name,'{}');
        }
        var ns={
            localStorage:$.extend({},$.localStorage,{_ns:name}),
            sessionStorage:$.extend({},$.sessionStorage,{_ns:name})
        };
        if($.cookie){
            if(!window.cookieStorage.getItem(name)) window.cookieStorage.setItem(name,'{}');
            ns.cookieStorage=$.extend({},$.cookieStorage,{_ns:name});
        }
        $.namespaceStorages[name]=ns;
        return ns;
    }

    // Test if storage is natively available on browser
    function _testStorage(name){
        var foo='jsapi';
        try{
            if(!window[name]) return false;
            window[name].setItem(foo,foo);
            window[name].removeItem(foo);
            return true;
        }catch(e){
            return false;
        }
    }

    // Check if storages are natively available on browser
    var storage_available=_testStorage('localStorage');

    // Namespace object
    var storage={
        _type:'',
        _ns:'',
        _callMethod:function(f,a){
            var p=[this._type],a=Array.prototype.slice.call(a),a0=a[0];
            if(this._ns) p.push(this._ns);
            if(typeof a0==='string' && a0.indexOf('.')!==-1){
                a.shift();
                [].unshift.apply(a,a0.split('.'));
            }
            [].push.apply(p,a);
            return f.apply(this,p);
        },
        // Get items. If no parameters and storage have a namespace, return all namespace
        get:function(){
            return this._callMethod(_get,arguments);
        },
        // Set items
        set:function(){
            var l=arguments.length,a=arguments,a0=a[0];
            if(l<1 || !$.isPlainObject(a0) && l<2) throw new Error('Minimum 2 arguments must be given or first parameter must be an object');
            // If first argument is an object and storage is a namespace storage, set values individually
            if($.isPlainObject(a0) && this._ns){
                for(var i in a0){
                    _set(this._type,this._ns,i,a0[i]);
                }
                return a0;
            }else{
                var r=this._callMethod(_set,a);
                if(this._ns) return r[a0.split('.')[0]];
                else return r;
            }
        },
        // Delete items
        remove:function(){
            if(arguments.length<1) throw new Error('Minimum 1 argument must be given');
            return this._callMethod(_remove,arguments);
        },
        // Delete all items
        removeAll:function(reinit_ns){
            if(this._ns){
                _set(this._type,this._ns,{});
                return true;
            }else{
                return _removeAll(this._type, reinit_ns);
            }
        },
        // Items empty
        isEmpty:function(){
            return this._callMethod(_isEmpty,arguments);
        },
        // Items exists
        isSet:function(){
            if(arguments.length<1) throw new Error('Minimum 1 argument must be given');
            return this._callMethod(_isSet,arguments);
        },
        // Get keys of items
        keys:function(){
            return this._callMethod(_keys,arguments);
        }
    };

    // Use jquery.cookie for compatibility with old browsers and give access to cookieStorage
    if($.cookie){
        // sessionStorage is valid for one window/tab. To simulate that with cookie, we set a name for the window and use it for the name of the cookie
        if(!window.name) window.name=Math.floor(Math.random()*100000000);
        var cookie_storage={
            _cookie:true,
            _prefix:'',
            _expires:null,
            _path:null,
            _domain:null,
            setItem:function(n,v){
                $.cookie(this._prefix+n,v,{expires:this._expires,path:this._path,domain:this._domain});
            },
            getItem:function(n){
                return $.cookie(this._prefix+n);
            },
            removeItem:function(n){
                return $.removeCookie(this._prefix+n);
            },
            clear:function(){
                for(var key in $.cookie()){
                    if(key!=''){
                        if(!this._prefix && key.indexOf(cookie_local_prefix)===-1 && key.indexOf(cookie_session_prefix)===-1 || this._prefix && key.indexOf(this._prefix)===0) {
                            $.removeCookie(key);
                        }
                    }
                }
            },
            setExpires:function(e){
                this._expires=e;
                return this;
            },
            setPath:function(p){
                this._path=p;
                return this;
            },
            setDomain:function(d){
                this._domain=d;
                return this;
            },
            setConf:function(c){
                if(c.path) this._path=c.path;
                if(c.domain) this._domain=c.domain;
                if(c.expires) this._expires=c.expires;
                return this;
            },
            setDefaultConf:function(){
                this._path=this._domain=this._expires=null;
            }
        };
        if(!storage_available){
            window.localCookieStorage=$.extend({},cookie_storage,{_prefix:cookie_local_prefix,_expires:365*10});
            window.sessionCookieStorage=$.extend({},cookie_storage,{_prefix:cookie_session_prefix+window.name+'_'});
        }
        window.cookieStorage=$.extend({},cookie_storage);
        // cookieStorage API
        $.cookieStorage=$.extend({},storage,{
            _type:'cookieStorage',
            setExpires:function(e){window.cookieStorage.setExpires(e); return this;},
            setPath:function(p){window.cookieStorage.setPath(p); return this;},
            setDomain:function(d){window.cookieStorage.setDomain(d); return this;},
            setConf:function(c){window.cookieStorage.setConf(c); return this;},
            setDefaultConf:function(){window.cookieStorage.setDefaultConf(); return this;}
        });
    }

    // Get a new API on a namespace
    $.initNamespaceStorage=function(ns){ return _createNamespace(ns); };
    if(storage_available) {
        // localStorage API
        $.localStorage=$.extend({},storage,{_type:'localStorage'});
        // sessionStorage API
        $.sessionStorage=$.extend({},storage,{_type:'sessionStorage'});
    }else{
        // localStorage API
        $.localStorage=$.extend({},storage,{_type:'localCookieStorage'});
        // sessionStorage API
        $.sessionStorage=$.extend({},storage,{_type:'sessionCookieStorage'});
    }
    // List of all namespace storage
    $.namespaceStorages={};
    // Remove all items in all storages
    $.removeAllStorages=function(reinit_ns){
        $.localStorage.removeAll(reinit_ns);
        $.sessionStorage.removeAll(reinit_ns);
        if($.cookieStorage) $.cookieStorage.removeAll(reinit_ns);
        if(!reinit_ns){
            $.namespaceStorages={};
        }
    }
})(jQuery);
},{}],31:[function(require,module,exports){
/* NProgress, (c) 2013, 2014 Rico Sta. Cruz - http://ricostacruz.com/nprogress
 * @license MIT */

;(function() {
    var NProgress = {};

    NProgress.version = '0.1.6';

    var Settings = NProgress.settings = {
        minimum: 0.08,
        easing: 'ease',
        positionUsing: '',
        speed: 200,
        trickle: true,
        trickleRate: 0.02,
        trickleSpeed: 800,
        showSpinner: true,
        barSelector: '[role="bar"]',
        spinnerSelector: '[role="spinner"]',
        parent: 'body',
        template: '<div class="bar" role="bar"><div class="peg"></div></div><div class="spinner" role="spinner"><div class="spinner-icon"></div></div>'
    };

    /**
     * Updates configuration.
     *
     *     NProgress.configure({
   *       minimum: 0.1
   *     });
     */
    NProgress.configure = function(options) {
        var key, value;
        for (key in options) {
            value = options[key];
            if (value !== undefined && options.hasOwnProperty(key)) Settings[key] = value;
        }

        return this;
    };

    /**
     * Last number.
     */

    NProgress.status = null;

    /**
     * Sets the progress bar status, where `n` is a number from `0.0` to `1.0`.
     *
     *     NProgress.set(0.4);
     *     NProgress.set(1.0);
     */

    NProgress.set = function(n) {
        var started = NProgress.isStarted();

        n = clamp(n, Settings.minimum, 1);
        NProgress.status = (n === 1 ? null : n);

        var progress = NProgress.render(!started),
            bar      = progress.querySelector(Settings.barSelector),
            speed    = Settings.speed,
            ease     = Settings.easing;

        progress.offsetWidth; /* Repaint */

        queue(function(next) {
            // Set positionUsing if it hasn't already been set
            if (Settings.positionUsing === '') Settings.positionUsing = NProgress.getPositioningCSS();

            // Add transition
            css(bar, barPositionCSS(n, speed, ease));

            if (n === 1) {
                // Fade out
                css(progress, {
                    transition: 'none',
                    opacity: 1
                });
                progress.offsetWidth; /* Repaint */

                setTimeout(function() {
                    css(progress, {
                        transition: 'all ' + speed + 'ms linear',
                        opacity: 0
                    });
                    setTimeout(function() {
                        NProgress.remove();
                        next();
                    }, speed);
                }, speed);
            } else {
                setTimeout(next, speed);
            }
        });

        return this;
    };

    NProgress.isStarted = function() {
        return typeof NProgress.status === 'number';
    };

    /**
     * Shows the progress bar.
     * This is the same as setting the status to 0%, except that it doesn't go backwards.
     *
     *     NProgress.start();
     *
     */
    NProgress.start = function() {
        if (!NProgress.status) NProgress.set(0);

        var work = function() {
            setTimeout(function() {
                if (!NProgress.status) return;
                NProgress.trickle();
                work();
            }, Settings.trickleSpeed);
        };

        if (Settings.trickle) work();

        return this;
    };

    /**
     * Hides the progress bar.
     * This is the *sort of* the same as setting the status to 100%, with the
     * difference being `done()` makes some placebo effect of some realistic motion.
     *
     *     NProgress.done();
     *
     * If `true` is passed, it will show the progress bar even if its hidden.
     *
     *     NProgress.done(true);
     */

    NProgress.done = function(force) {
        if (!force && !NProgress.status) return this;

        return NProgress.inc(0.3 + 0.5 * Math.random()).set(1);
    };

    /**
     * Increments by a random amount.
     */

    NProgress.inc = function(amount) {
        var n = NProgress.status;

        if (!n) {
            return NProgress.start();
        } else {
            if (typeof amount !== 'number') {
                amount = (1 - n) * clamp(Math.random() * n, 0.1, 0.95);
            }

            n = clamp(n + amount, 0, 0.994);
            return NProgress.set(n);
        }
    };

    NProgress.trickle = function() {
        return NProgress.inc(Math.random() * Settings.trickleRate);
    };

    /**
     * Waits for all supplied jQuery promises and
     * increases the progress as the promises resolve.
     *
     * @param $promise jQUery Promise
     */
    (function() {
        var initial = 0, current = 0;

        NProgress.promise = function($promise) {
            if (!$promise || $promise.state() == "resolved") {
                return this;
            }

            if (current == 0) {
                NProgress.start();
            }

            initial++;
            current++;

            $promise.always(function() {
                current--;
                if (current == 0) {
                    initial = 0;
                    NProgress.done();
                } else {
                    NProgress.set((initial - current) / initial);
                }
            });

            return this;
        };

    })();

    /**
     * (Internal) renders the progress bar markup based on the `template`
     * setting.
     */

    NProgress.render = function(fromStart) {
        if (NProgress.isRendered()) return document.getElementById('nprogress');

        addClass(document.documentElement, 'nprogress-busy');

        var progress = document.createElement('div');
        progress.id = 'nprogress';
        progress.innerHTML = Settings.template;

        var bar      = progress.querySelector(Settings.barSelector),
            perc     = fromStart ? '-100' : toBarPerc(NProgress.status || 0),
            parent   = document.querySelector(Settings.parent),
            spinner;

        css(bar, {
            transition: 'all 0 linear',
            transform: 'translate3d(' + perc + '%,0,0)'
        });

        if (!Settings.showSpinner) {
            spinner = progress.querySelector(Settings.spinnerSelector);
            spinner && removeElement(spinner);
        }

        if (parent != document.body) {
            addClass(parent, 'nprogress-custom-parent');
        }

        parent.appendChild(progress);
        return progress;
    };

    /**
     * Removes the element. Opposite of render().
     */

    NProgress.remove = function() {
        removeClass(document.documentElement, 'nprogress-busy');
        removeClass(document.querySelector(Settings.parent), 'nprogress-custom-parent')
        var progress = document.getElementById('nprogress');
        progress && removeElement(progress);
    };

    /**
     * Checks if the progress bar is rendered.
     */

    NProgress.isRendered = function() {
        return !!document.getElementById('nprogress');
    };

    /**
     * Determine which positioning CSS rule to use.
     */

    NProgress.getPositioningCSS = function() {
        // Sniff on document.body.style
        var bodyStyle = document.body.style;

        // Sniff prefixes
        var vendorPrefix = ('WebkitTransform' in bodyStyle) ? 'Webkit' :
            ('MozTransform' in bodyStyle) ? 'Moz' :
                ('msTransform' in bodyStyle) ? 'ms' :
                    ('OTransform' in bodyStyle) ? 'O' : '';

        if (vendorPrefix + 'Perspective' in bodyStyle) {
            // Modern browsers with 3D support, e.g. Webkit, IE10
            return 'translate3d';
        } else if (vendorPrefix + 'Transform' in bodyStyle) {
            // Browsers without 3D support, e.g. IE9
            return 'translate';
        } else {
            // Browsers without translate() support, e.g. IE7-8
            return 'margin';
        }
    };

    /**
     * Helpers
     */

    function clamp(n, min, max) {
        if (n < min) return min;
        if (n > max) return max;
        return n;
    }

    /**
     * (Internal) converts a percentage (`0..1`) to a bar translateX
     * percentage (`-100%..0%`).
     */

    function toBarPerc(n) {
        return (-1 + n) * 100;
    }


    /**
     * (Internal) returns the correct CSS for changing the bar's
     * position given an n percentage, and speed and ease from Settings
     */

    function barPositionCSS(n, speed, ease) {
        var barCSS;

        if (Settings.positionUsing === 'translate3d') {
            barCSS = { transform: 'translate3d('+toBarPerc(n)+'%,0,0)' };
        } else if (Settings.positionUsing === 'translate') {
            barCSS = { transform: 'translate('+toBarPerc(n)+'%,0)' };
        } else {
            barCSS = { 'margin-left': toBarPerc(n)+'%' };
        }

        barCSS.transition = 'all '+speed+'ms '+ease;

        return barCSS;
    }

    /**
     * (Internal) Queues a function to be executed.
     */

    var queue = (function() {
        var pending = [];

        function next() {
            var fn = pending.shift();
            if (fn) {
                fn(next);
            }
        }

        return function(fn) {
            pending.push(fn);
            if (pending.length == 1) next();
        };
    })();

    /**
     * (Internal) Applies css properties to an element, similar to the jQuery
     * css method.
     *
     * While this helper does assist with vendor prefixed property names, it
     * does not perform any manipulation of values prior to setting styles.
     */

    var css = (function() {
        var cssPrefixes = [ 'Webkit', 'O', 'Moz', 'ms' ],
            cssProps    = {};

        function camelCase(string) {
            return string.replace(/^-ms-/, 'ms-').replace(/-([\da-z])/gi, function(match, letter) {
                return letter.toUpperCase();
            });
        }

        function getVendorProp(name) {
            var style = document.body.style;
            if (name in style) return name;

            var i = cssPrefixes.length,
                capName = name.charAt(0).toUpperCase() + name.slice(1),
                vendorName;
            while (i--) {
                vendorName = cssPrefixes[i] + capName;
                if (vendorName in style) return vendorName;
            }

            return name;
        }

        function getStyleProp(name) {
            name = camelCase(name);
            return cssProps[name] || (cssProps[name] = getVendorProp(name));
        }

        function applyCss(element, prop, value) {
            prop = getStyleProp(prop);
            element.style[prop] = value;
        }

        return function(element, properties) {
            var args = arguments,
                prop,
                value;

            if (args.length == 2) {
                for (prop in properties) {
                    value = properties[prop];
                    if (value !== undefined && properties.hasOwnProperty(prop)) applyCss(element, prop, value);
                }
            } else {
                applyCss(element, args[1], args[2]);
            }
        }
    })();

    /**
     * (Internal) Determines if an element or space separated list of class names contains a class name.
     */

    function hasClass(element, name) {
        var list = typeof element == 'string' ? element : classList(element);
        return list.indexOf(' ' + name + ' ') >= 0;
    }

    /**
     * (Internal) Adds a class to an element.
     */

    function addClass(element, name) {
        var oldList = classList(element),
            newList = oldList + name;

        if (hasClass(oldList, name)) return;

        // Trim the opening space.
        element.className = newList.substring(1);
    }

    /**
     * (Internal) Removes a class from an element.
     */

    function removeClass(element, name) {
        var oldList = classList(element),
            newList;

        if (!hasClass(element, name)) return;

        // Replace the class name.
        newList = oldList.replace(' ' + name + ' ', ' ');

        // Trim the opening and closing spaces.
        element.className = newList.substring(1, newList.length - 1);
    }

    /**
     * (Internal) Gets a space separated list of the class names on the element.
     * The list is wrapped with a single space on each end to facilitate finding
     * matches within the list.
     */

    function classList(element) {
        return (' ' + (element.className || '') + ' ').replace(/\s+/gi, ' ');
    }

    /**
     * (Internal) Removes an element from the DOM.
     */

    function removeElement(element) {
        element && element.parentNode && element.parentNode.removeChild(element);
    }

    window['NProgress'] = NProgress;
})();

},{}],32:[function(require,module,exports){
/*
 * Toastr
 * Copyright 2012-2015
 * Authors: John Papa, Hans Fjällemark, and Tim Ferrell.
 * All Rights Reserved.
 * Use, reproduction, distribution, and modification of this code is subject to the terms and
 * conditions of the MIT license, available at http://www.opensource.org/licenses/mit-license.php
 *
 * ARIA Support: Greta Krafsig
 *
 * Project: https://github.com/CodeSeven/toastr
 */
/* global define */
(function($) {
    window['toastr'] = (function () {
        var $container;
        var listener;
        var toastId = 0;
        var toastType = {
            error: 'error',
            info: 'info',
            success: 'success',
            warning: 'warning'
        };

        var toastr = {
            clear: clear,
            remove: remove,
            error: error,
            getContainer: getContainer,
            info: info,
            options: {},
            subscribe: subscribe,
            success: success,
            version: '2.1.1',
            warning: warning
        };

        var previousToast;

        return toastr;

        ////////////////

        function error(message, title, optionsOverride) {
            return notify({
                type: toastType.error,
                iconClass: getOptions().iconClasses.error,
                message: message,
                optionsOverride: optionsOverride,
                title: title
            });
        }

        function getContainer(options, create) {
            if (!options) { options = getOptions(); }
            $container = $('#' + options.containerId);
            if ($container.length) {
                return $container;
            }
            if (create) {
                $container = createContainer(options);
            }
            return $container;
        }

        function info(message, title, optionsOverride) {
            return notify({
                type: toastType.info,
                iconClass: getOptions().iconClasses.info,
                message: message,
                optionsOverride: optionsOverride,
                title: title
            });
        }

        function subscribe(callback) {
            listener = callback;
        }

        function success(message, title, optionsOverride) {
            return notify({
                type: toastType.success,
                iconClass: getOptions().iconClasses.success,
                message: message,
                optionsOverride: optionsOverride,
                title: title
            });
        }

        function warning(message, title, optionsOverride) {
            return notify({
                type: toastType.warning,
                iconClass: getOptions().iconClasses.warning,
                message: message,
                optionsOverride: optionsOverride,
                title: title
            });
        }

        function clear($toastElement, clearOptions) {
            var options = getOptions();
            if (!$container) { getContainer(options); }
            if (!clearToast($toastElement, options, clearOptions)) {
                clearContainer(options);
            }
        }

        function remove($toastElement) {
            var options = getOptions();
            if (!$container) { getContainer(options); }
            if ($toastElement && $(':focus', $toastElement).length === 0) {
                removeToast($toastElement);
                return;
            }
            if ($container.children().length) {
                $container.remove();
            }
        }

        // internal functions

        function clearContainer (options) {
            var toastsToClear = $container.children();
            for (var i = toastsToClear.length - 1; i >= 0; i--) {
                clearToast($(toastsToClear[i]), options);
            }
        }

        function clearToast ($toastElement, options, clearOptions) {
            var force = clearOptions && clearOptions.force ? clearOptions.force : false;
            if ($toastElement && (force || $(':focus', $toastElement).length === 0)) {
                $toastElement[options.hideMethod]({
                    duration: options.hideDuration,
                    easing: options.hideEasing,
                    complete: function () { removeToast($toastElement); }
                });
                return true;
            }
            return false;
        }

        function createContainer(options) {
            $container = $('<div/>')
                .attr('id', options.containerId)
                .addClass(options.positionClass)
                .attr('aria-live', 'polite')
                .attr('role', 'alert');

            $container.appendTo($(options.target));
            return $container;
        }

        function getDefaults() {
            return {
                tapToDismiss: true,
                toastClass: 'toast',
                containerId: 'toast-container',
                debug: false,

                showMethod: 'fadeIn', //fadeIn, slideDown, and show are built into jQuery
                showDuration: 300,
                showEasing: 'swing', //swing and linear are built into jQuery
                onShown: undefined,
                hideMethod: 'fadeOut',
                hideDuration: 1000,
                hideEasing: 'swing',
                onHidden: undefined,

                extendedTimeOut: 1000,
                iconClasses: {
                    error: 'toast-error',
                    info: 'toast-info',
                    success: 'toast-success',
                    warning: 'toast-warning'
                },
                iconClass: 'toast-info',
                positionClass: 'toast-top-right',
                timeOut: 5000, // Set timeOut and extendedTimeOut to 0 to make it sticky
                titleClass: 'toast-title',
                messageClass: 'toast-message',
                target: 'body',
                closeHtml: '<button type="button">&times;</button>',
                newestOnTop: true,
                preventDuplicates: false,
                progressBar: false
            };
        }

        function publish(args) {
            if (!listener) { return; }
            listener(args);
        }

        function notify(map) {
            var options = getOptions();
            var iconClass = map.iconClass || options.iconClass;

            if (typeof (map.optionsOverride) !== 'undefined') {
                options = $.extend(options, map.optionsOverride);
                iconClass = map.optionsOverride.iconClass || iconClass;
            }

            if (shouldExit(options, map)) { return; }

            toastId++;

            $container = getContainer(options, true);

            var intervalId = null;
            var $toastElement = $('<div/>');
            var $titleElement = $('<div/>');
            var $messageElement = $('<div/>');
            var $progressElement = $('<div/>');
            var $closeElement = $(options.closeHtml);
            var progressBar = {
                intervalId: null,
                hideEta: null,
                maxHideTime: null
            };
            var response = {
                toastId: toastId,
                state: 'visible',
                startTime: new Date(),
                options: options,
                map: map
            };

            personalizeToast();

            displayToast();

            handleEvents();

            publish(response);

            if (options.debug && console) {
                console.log(response);
            }

            return $toastElement;

            function personalizeToast() {
                setIcon();
                setTitle();
                setMessage();
                setCloseButton();
                setProgressBar();
                setSequence();
            }

            function handleEvents() {
                $toastElement.hover(stickAround, delayedHideToast);
                if (!options.onclick && options.tapToDismiss) {
                    $toastElement.click(hideToast);
                }

                if (options.closeButton && $closeElement) {
                    $closeElement.click(function (event) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (event.cancelBubble !== undefined && event.cancelBubble !== true) {
                            event.cancelBubble = true;
                        }
                        hideToast(true);
                    });
                }

                if (options.onclick) {
                    $toastElement.click(function () {
                        options.onclick();
                        hideToast();
                    });
                }
            }

            function displayToast() {
                $toastElement.hide();

                $toastElement[options.showMethod](
                    {duration: options.showDuration, easing: options.showEasing, complete: options.onShown}
                );

                if (options.timeOut > 0) {
                    intervalId = setTimeout(hideToast, options.timeOut);
                    progressBar.maxHideTime = parseFloat(options.timeOut);
                    progressBar.hideEta = new Date().getTime() + progressBar.maxHideTime;
                    if (options.progressBar) {
                        progressBar.intervalId = setInterval(updateProgress, 10);
                    }
                }
            }

            function setIcon() {
                if (map.iconClass) {
                    $toastElement.addClass(options.toastClass).addClass(iconClass);
                }
            }

            function setSequence() {
                if (options.newestOnTop) {
                    $container.prepend($toastElement);
                } else {
                    $container.append($toastElement);
                }
            }

            function setTitle() {
                if (map.title) {
                    $titleElement.append(map.title).addClass(options.titleClass);
                    $toastElement.append($titleElement);
                }
            }

            function setMessage() {
                if (map.message) {
                    $messageElement.append(map.message).addClass(options.messageClass);
                    $toastElement.append($messageElement);
                }
            }

            function setCloseButton() {
                if (options.closeButton) {
                    $closeElement.addClass('toast-close-button').attr('role', 'button');
                    $toastElement.prepend($closeElement);
                }
            }

            function setProgressBar() {
                if (options.progressBar) {
                    $progressElement.addClass('toast-progress');
                    $toastElement.prepend($progressElement);
                }
            }

            function shouldExit(options, map) {
                if (options.preventDuplicates) {
                    if (map.message === previousToast) {
                        return true;
                    } else {
                        previousToast = map.message;
                    }
                }
                return false;
            }

            function hideToast(override) {
                if ($(':focus', $toastElement).length && !override) {
                    return;
                }
                clearTimeout(progressBar.intervalId);
                return $toastElement[options.hideMethod]({
                    duration: options.hideDuration,
                    easing: options.hideEasing,
                    complete: function () {
                        removeToast($toastElement);
                        if (options.onHidden && response.state !== 'hidden') {
                            options.onHidden();
                        }
                        response.state = 'hidden';
                        response.endTime = new Date();
                        publish(response);
                    }
                });
            }

            function delayedHideToast() {
                if (options.timeOut > 0 || options.extendedTimeOut > 0) {
                    intervalId = setTimeout(hideToast, options.extendedTimeOut);
                    progressBar.maxHideTime = parseFloat(options.extendedTimeOut);
                    progressBar.hideEta = new Date().getTime() + progressBar.maxHideTime;
                }
            }

            function stickAround() {
                clearTimeout(intervalId);
                progressBar.hideEta = 0;
                $toastElement.stop(true, true)[options.showMethod](
                    {duration: options.showDuration, easing: options.showEasing}
                );
            }

            function updateProgress() {
                var percentage = ((progressBar.hideEta - (new Date().getTime())) / progressBar.maxHideTime) * 100;
                $progressElement.width(percentage + '%');
            }
        }

        function getOptions() {
            return $.extend({}, getDefaults(), toastr.options);
        }

        function removeToast($toastElement) {
            if (!$container) { $container = getContainer(); }
            if ($toastElement.is(':visible')) {
                return;
            }
            $toastElement.remove();
            $toastElement = null;
            if ($container.children().length === 0) {
                $container.remove();
                previousToast = undefined;
            }
        }

    })();
})(jQuery);
},{}],33:[function(require,module,exports){

var ValueCollection = require('./../collections/Values');
var SectionView = require('./Section');
var SubSectionView = require('./SubSection');

module.exports = Backbone.View.extend({
    //el: #wpas_panel,

    events: {
        'click a.wpas_button_save'    : 'save',
        'click a.wpas_button_reset'   : 'reset',
        'click a.wpas_button_resetall': 'resetAll',
        'change .wpas_autosave input': 'autoSaveInputChange',
        'click a.ut_button_importexport': 'importExport',
        'click a.ut_button_support': 'support'
    },

    initialize: function (settings) {
        var me = this,
            $ = Backbone.$;

        me.storage = $.initNamespaceStorage('UT').localStorage;

        _.bindAll(me, 'fixBottomBar');
        me.saveDebounce = _.debounce(me.save, 500);

        me.router = settings.router;

        me.$window = $(window);
        me.$panel = $('#wpas_panel');
        me.$container = me.$panel.find('.wpas_container');
        me.$sections = me.$container.find('.wpas_sections');
        me.$sectionsUl = me.$sections.find('ul');
        me.$bottomBar = me.$panel.find('.wpas_bottom');
        me.$saveButton = me.$bottomBar.find('.wpas_button_save');

        if(me.storage.get('optionAutoSave')) {
            me.$panel.find('.wpas_autosave input').prop('checked', true);
            me.setAutoSave( true );
        }

        UT.values.bind('change', function() {
            me.setDirty(true);
        });

        UT.sections.where( {parent_id:0} ).forEach(function (section) {//
            var sectionView = new SectionView({model: section});
            section.view = sectionView;
            var e = sectionView.render();
            me.$sectionsUl.append(e.el);

            me.router.route(section.get('slug'), function () {
                UT.sections.setActive(section);
            });

            if( section.get('id') > 0 ) {
                var $subUl = $('<ul/>');
                e.$el.append($subUl);
                UT.sections.where({parent_id: section.get('id')}).forEach(function(subSection) {
                    var subSectionView = new SubSectionView({model: subSection});
                    subSection.view = subSectionView;
                    var e = subSectionView.render();
                    $subUl.append(e.el);

                    me.router.route(subSection.get('slug'), function () {
                        UT.sections.setActive(subSection);
                    });
                });
            }
        });

        me.initRoleSelector();

//        me.fixBottomBar();
        setTimeout(me.fixBottomBar, 1);
        me.$window.scroll(me.fixBottomBar);
    },

    initRoleSelector: function() {
        var me = this,
            $ = Backbone.$;
        me.$roleSelectorSelect = me.$panel.find('.ut_role_selection');
        me.$roleSelectorSelect.empty();

//        me.$roleSelectorSelect.append( $('<option/>', { value:'', html: 'All roles and visitors' }) );
        UT.roles.forEach(function(role) {
            me.$roleSelectorSelect.append( $('<option/>', { value:role.id, html: role.get('name') }) );
        });

        me.$roleSelectorSelect.on('change', function() {
            var value = $(this).val();

            me.loadRoleValues( value );

            me.storage.set('optionLastRole', value);

            UT.sections.forEach(function(section) {
                if(value !== '') {
                    section.view.setHidden(section.get('visibility') != 'all_roles');
                } else {
                    section.view.setHidden(false);
                }
            });

            var activeSection = UT.sections.where( {isActive:true} ).shift();
            if(activeSection && activeSection.get('isHidden')) {
                var firstVisible = UT.sections.where( {isHidden:false} ).shift();
                UT.app.router.navigate(firstVisible.get('slug'), true);
            }
        });

//        if(me.storage.get('optionLastRole')) {
//            me.$roleSelectorSelect.val(me.storage.get('optionLastRole')).trigger('change');
//        }
    },

    loadRoleValues: function( role ) {
        var me = this;

        UT.currentRole = role;
        me.refreshPanel();
    },

    refreshPanel: function() {
        var activeSection = UT.sections.where( {isActive:true} ).shift();
        if(activeSection) {
            _.each(activeSection.view.fieldViews, function( fieldView ) {
                var value = UT.values.getValue(fieldView.model.id);
//                console.log(fieldView.model.id, value);
                value ? fieldView.setValue(value) : fieldView.reset();
            })
        }
    },

    setIsSaving: function( isSaving ) {
        var me = this;

        if(isSaving) {
            me.$saveButton.addClass('is_saving');
        } else {
            me.$saveButton.removeClass('is_saving');
        }
    },

    autoSaveInputChange: function () {
        var me = this;

        me.setAutoSave(me.$panel.find('.wpas_autosave input').prop('checked'));
    },

    setAutoSave: function ( isEnabled ) {
        var me = this,
            $ = Backbone.$;

        me.isAutoSave = isEnabled;

        if(isEnabled) {
            UT.values.bind('change', me.saveDebounce, me);
        } else {
            UT.values.unbind('change', me.saveDebounce);
        }

        me.storage.set('optionAutoSave', isEnabled);
    },

    _returnDirtyMessage: function() {
        return 'Settings is unsaved. Do you really want to close page?';
    },

    setDirty: function ( isDirty ) {
        var me = this,
            $ = Backbone.$;

        if(isDirty) {
            $(window).bind('beforeunload', me._returnDirtyMessage);
        } else {
            $(window).unbind('beforeunload', me._returnDirtyMessage);
        }
    },

    reset: function () {
        if(confirm('Do you really want to reset this section settings?')) {
            var activeSection = UT.sections.where( {isActive:true} ).shift();
            if(activeSection) {
                _.each(activeSection.view.fieldViews, function( fieldView ) {
                    UT.values.setValue(fieldView.model.id, fieldView.model.get('default'));
                })
            }
            this.refreshPanel();
            toastr.warning('You need to save to apply resets!');
        }
    },

    resetAll: function () {
        if(confirm('Do you really want to reset all settings?')) {
            UT.values = ValueCollection.createFromJSON({}, UT.roles);
            this.refreshPanel();
//            this.save();
            toastr.warning('You need to save to apply resets!');
        }
    },

    save: function () {
        var me = this,
            data = {};

        if(me.$saveButton.hasClass('is_saving')) return;
        if(me.lastXhr) me.lastXhr.abort();

        !me.lastXhr && NProgress.start();

        UT.values.each(function( value ) {
            data[value.id] = value.toJSON();
        });
        me.setIsSaving(true);

        !me.lastXhr && NProgress.set(0.4);
        me.lastXhr = Backbone.$.post(ajaxurl, { action: 'ut_save', _wpnonce: UT.nonce, data: JSON.stringify(data) },
            function(data) {
                me.setIsSaving(false);
                me.setDirty(false);
                if(UT.debug) console.log(data);

                NProgress.done();
                !me.isAutoSave && toastr.info('Settings saved.');

                me.lastXhr = null;
            }, 'json')
            .error(function(ev) {
                me.setIsSaving(false);
                var text = ev.responseText;
                me.lastXhr = null;
                toastr.error('Error, Please try reload page and write to support@amino-studio.com, we will help you.');
                console.log(text);
            });

    },

    fixBottomBar: function () {
        var me = this,
            panelRect = me.$container[0].getBoundingClientRect();

        if (panelRect.height + panelRect.top > me.$window.height()) {
            me.$bottomBar.css('width', panelRect.width - 200).addClass('fixed');
        } else {
            me.$bottomBar.css('width', '').removeClass('fixed');
        }
    },

    importExportTpl: _.template('<div class="ut_modal">' +
        '<div class="ut_window_title"><h1><%= title %><a class="close"></a></h1>' +
            '<div class="ut_window_body">' +
                '<%= html %>' +
            '</div>' +
        '</div></div>'),

    importExport: function(ev) {
        var me = this,
            $ = Backbone.$;

        ev.preventDefault();
        ev.stopPropagation();

        var data = {};
        UT.values.each(function( value ) {
            data[value.id] = value.toJSON();
        });

        var $window = $(me.importExportTpl({
            title: 'Import/Export',
            html: '' +
                '<div class="ut_window_section ut_window_import">' +
                    '<h3>Export</h3>' +
                    '<div class="ut_section_body " style="padding: 0 20px;padding-bottom: 20px">' +
                        '<textarea onclick="jQuery(this).select()">'+ JSON.stringify({ values: data }) +'</textarea>' +
                    '</div>' +
                '</div>' +

                '<div class="ut_window_section ut_window_import">' +
                    '<h3>Import</h3>' +
                        '<div class="ut_section_body" style="padding: 0 20px;padding-bottom: 20px">' +
                            '<textarea class="import_textarea"></textarea>' +
                            '<a class="wpas_button import_button">Import Data</a>'+
                        '</div>' +
                    '</div>' +
                '</div>' +
                ''}));
        $window.find('.close').click(function() {
            $window.remove();
        });
        $window.find('.import_button').click(function() {
            var text = $window.find('.import_textarea').val();
            if(!text) return;

            try {
                var data = $.parseJSON(text);
            } catch(err){
                alert("Parse error, please enter correct data.");
                return;
            }
            if( !data.values ) {
                alert("Invalid format, please enter correct data.");
                return;
            }

            UT.values = ValueCollection.createFromJSON(data.values, UT.roles);
            toastr.warning('You need to save to apply import!');

            me.refreshPanel();
            $window.remove();
        });
        $('body').click(function(ev) {
            if($(ev.target).closest('.ut_modal').length) return;
            $window.remove();
        });

//        var $dragging;
//        $(document.body).on("mousemove", function(e) {
//            if ($dragging) {
//                $dragging.offset({
//                    top: e.pageY,
//                    left: e.pageX
//                });
//            }
//        });
//
//
//        $(document.body).on("mousedown", "div", function (e) {
//            $dragging = $window;
//        });
//
//        $(document.body).on("mouseup", function (e) {
//            $dragging = null;
//        });

        me.$panel.append($window);
    },

    support: function(ev) {
        var me = this,
            $ = Backbone.$;

        ev.preventDefault();
        ev.stopPropagation();

        var $window = $(me.importExportTpl({
            title: 'Support',
            html: '' +
            '<div class="ut_window_section ut_window_import">' +
            '<h3>Support or Suggestion</h3>' +
            '<div class="ut_section_body " style="padding: 0 20px;padding-bottom: 20px">' +
                'If you have any problem and/or suggestion, please, write us to <a href="mailto:support@amino-studio.com?subject=Ultimate Tweaker Support Message" target="_blank">support@amino-studio.com</a>' +
            '</div>' +
            '</div>' +
            ''
        }));
        $window.find('.close').click(function () {
            $window.remove();
        });
        $('body').click(function(ev) {
            if($(ev.target).closest('.ut_modal').length) return;
            $window.remove();
        });

        me.$panel.append($window);
    }
});

},{"./../collections/Values":5,"./Section":35,"./SubSection":36}],34:[function(require,module,exports){
var TextField = require('./../fields/Text');
var SwitchField = require('./../fields/Switch');
var CheckboxField = require('./../fields/Checkbox');
var TextareaField = require('./../fields/Textarea');
var SliderField = require('./../fields/Slider');
var SelectField = require('./../fields/Select');
var RadioField = require('./../fields/Radio');
var MediaField = require('./../fields/Media');
var ColorField = require('./../fields/Color');
var DimensionsField = require('./../fields/Dimensions');
var SpacingField = require('./../fields/Spacing');
var InfoFieldField = require('./../fields/InfoField');
var InfoField = require('./../fields/Info');
var SectionField = require('./../fields/Section');
var RawField = require('./../fields/Raw');
var TranslateTextField = require('./../fields/TranslateText');
var MetaboxHideField = require('./../fields/MetaboxHide');

module.exports = Backbone.View.extend({
    tagName: 'div',
    className: "wpas_field",
    grayBackground: 0,

    tpl: _.template(
        '<div class="wpas_field_title">' +
            '<%= title %>' +
            '<% if (typeof(right_title) !== "undefined" && right_title) { %>' +
            '<div class="wpas_field_title_right"><%= right_title %></div>' +
            '<% } %>' +
        '</div>' +
        '<div class="wpas_field_container">' +
            '<% if (typeof(desc) !== "undefined" && desc) { %>' +
                '<div class="wpas_field_desc"><%= desc %></div>' +
            '<% } %>' +
        '</div>'
    ),

    events: {
        'click': 'select'
    },

    initialize: function (settings) {
        var me = this;

        me.initRequired();

        me.$el.addClass([
            'wpas_field_' + settings.model.get('type'),
            settings.grayBackground ? 'wpas_field_gray_bg' : '',
            'wpas_field_key_' + settings.model.id
        ].join(' '));
        me.listenTo(me.model, "change", me.render);
    },

    initRequired: function() {
        var me = this,
            required = me.model.get('required');

        if(!required) return;

        me.checkRequired();
        UT.values.on('change', function() {
            me.checkRequired();
        });
    },

    checkRequired: function() {
        var me = this,
            required = me.model.get('required');

        if(!required) return;

        var field_id = required[0];
        var type = required[1]; //'-'
        var value = required[2];

        var currentValue = UT.values.getValue(field_id);

        var isValid = true;
        switch(type) {
            case '=':
            default:
                isValid = currentValue == value;
                break;
        }

        if(isValid) {
            if (me.isRendered) {
                me.$el.slideDown();
            } else {}
        } else {
            if (me.isRendered) {
                me.$el.slideUp();
            } else {
                me.$el.hide();
            }
        }
    },

    setValue: function( value ) {
        this.field.setValue(value);
    },

    reset: function( ) {
        this.setValue(this.model.get('default'));
    },

    render: function () {
        var me = this,
            clsName;

        if( me.isRendered ) {

        } else {
            me.isRendered = true;
            me.$el.html(me.tpl(me.model.attributes));
            me.$container = me.$el.find('.wpas_field_container');


            switch(this.model.get('type')) {
                case 'switch':
                    clsName = SwitchField;
                    break;
                case 'slider':
                    clsName = SliderField;
                    break;
                case 'checkbox':
                    clsName = CheckboxField;
                    break;
                case 'textarea':
                    clsName = TextareaField;
                    break;
                case 'radio':
                    clsName = RadioField;
                    break;
                case 'color':
                    clsName = ColorField;
                    break;
                case 'media':
                    clsName = MediaField;
                    break;
                case 'select':
                    clsName = SelectField;
                    break;
                case 'text':
                    clsName = TextField;
                    break;
                case 'dimensions':
                    clsName = DimensionsField;
                    break;
                case 'spacing':
                    clsName = SpacingField;
                    break;
                case 'info':
                    clsName = InfoField;
                    break;
                case 'info_field':
                    clsName = InfoFieldField;
                    break;
                case 'section':
                    clsName = SectionField;
                    break;
                case 'raw':
                    clsName = RawField;
                    break;
                case 'translate_text':
                    clsName = TranslateTextField;
                    break;
                case 'metabox_hide':
                    clsName = MetaboxHideField;
                    break;
                default:
                    clsName = TextField;
                    console.log(this.model.get('type'), this.model.attributes, UT.values.get(this.model.id));
                    break;
            }


            if(clsName) {
                var field = new clsName({model: me.model, fieldBody: me});
                field.on('change', UT.values.setValue, UT.values);
                field.render();

                me.$container.prepend(field.el);
            }

            me.field = field;
        }


        return this;
    }
});

},{"./../fields/Checkbox":7,"./../fields/Color":8,"./../fields/Dimensions":9,"./../fields/Info":10,"./../fields/InfoField":11,"./../fields/Media":12,"./../fields/MetaboxHide":13,"./../fields/Radio":14,"./../fields/Raw":15,"./../fields/Section":16,"./../fields/Select":17,"./../fields/Slider":18,"./../fields/Spacing":19,"./../fields/Switch":20,"./../fields/Text":21,"./../fields/Textarea":22,"./../fields/TranslateText":23}],35:[function(require,module,exports){

module.exports = Backbone.View.extend({
    tagName: 'li',
    className: "wpas_section",

    sectionTpl: _.template('<a href="#<%= slug %>">' +
    '<% if (typeof(icon_type) !== "undefined" && icon_type == "image") { %>' +
        '<img class="icon" src="<%= icon %>" />' +
    '<% } else { %>' +
        '<i class="<%= icon %>"></i>' +
    '<% } %>' +
    '<span><%= title %></span>' +
    '<% if (this.model.haveChilds()) { %>' +
        '<span class="collapse-icon"><i class="dashicons dashicons-arrow-right-alt2"></i></span>' +
    '<% } %>' +
    '</a>'),


    sectionBodyTpl: _.template('<div class="wpas_body_section"><div class="wpas_body_section_body"></div></div>'),

    events: {
        'click': 'select'
    },

    initialize: function (settings) {
        var me = this;

        me.$el.prop('href', '#' + me.model.get('slug'));
        me.$el.html(me.sectionTpl(me.model.attributes));
        me.$childsUl = me.$el.find('> ul');
        me.listenTo(me.model, "change:isActive", me.changeActive);
        me.listenTo(me.model, "change:showChilds", me.changeShowChilds);
//        me.listenTo(me.model, "change:isHidden", me.changeIsHidden);

        me.model.bind('activate', me.activatePage, me);
        me.model.bind('activateChild', me.activateChild, me);
    },

    changeActive: function () {
        var me = this,
            $ = Backbone.$;

        this.$el.toggleClass('active', this.model.get('isActive'));
        return this;
    },

    render: function () {
        var me = this,
            $ = Backbone.$;


        me.changeActive();
        me.changeShowChilds();

        return this;
    },

    setHidden: function (value) {
        var me = this,
            $ = Backbone.$;

        if(value) {
            me.$el.slideUp();
            me.model.set('isHidden', true);
        } else {
            me.$el.slideDown();
            me.model.set('isHidden', false);
        }
    },

    changeShowChilds: function () {
        var me = this,
            $ = Backbone.$;

        me.$el.toggleClass('child_active', me.model.get('showChilds'));

//        if(this.model.get('showChilds')) {
//            var sum = 0;
//
//            me.$childsUl.children().each(function() {
//                sum += $(this).outerHeight(true);
//            });
//
//            me.$childsUl.css('max-height', sum+'px');
//        } else {
//            me.$childsUl.css('max-height', '0px');
//        }
        return me;
    },

    activateChild: function() {
        var me = this,
            $ = Backbone.$;

        me.$el.addClass('child_active');
    },

    fieldViews: null,
    activatePage: function() {
        var me = this,
            $ = Backbone.$,
            $body = $('.wpas_body');

        me.fieldViews = [];
        $body.empty();
//return;
        $body.append($('<h1/>', { html: me.model.get('title') }));

        var df = document.createDocumentFragment();
//        console.log(me.model.attributes);
        _.each(me.model.getTweaks().groupBy('group'), function( tweaks, group ) {
            var tweaksDom = document.createDocumentFragment();
            var i = 1;
            _.each(tweaks, function( tweak ) {
                i++;
                if(tweak) {
                    tweak.getFields().each(function (field) {
                        var value = UT.values.getValue(field.id);
                        var view = field.getView({ grayBackground: i%2 });
                        value ? view.setValue(value) : view.reset();

                        me.fieldViews.push(view);
                        tweaksDom.appendChild(view.el)
                    });
                }
            });

            var sa = [];
            if(group) {
                var groupModel = UT.tweak_groups.get(group);
                if(groupModel) group = groupModel.get('title');
                sa.push($('<h3/>', { html: group })[0]);
            }
            sa.push($('<div/>', {
                'class':'wpas_body_section_body',
                html:tweaksDom
            }));

            df.appendChild($('<div/>', {
                'class':'wpas_body_section',
                html: sa
            })[0]);
        });

        $body.append(df);
    },

    select: function () {

    }
});

},{}],36:[function(require,module,exports){

var SectionView = require('./Section');

module.exports = SectionView.extend({
    tagName: 'li',
    className: "wpas_section",

    sectionTpl: _.template('<a href="#<%= slug %>">' +
    '<% if (typeof(icon_type) !== "undefined" && icon_type == "image") { %>' +
        '<img class="icon" src="<%= icon %>" />' +
    '<% } else { %>' +
        '<i class="<%= icon %>"></i>' +
    '<% } %>' +
    '<span><%= title %></span></a>'),


    sectionBodyTpl: _.template('<div class="wpas_body_section"><div class="wpas_body_section_body"></div></div>'),

    events: {
        'click': 'select'
    },

    initialize: function (settings) {
        var me = this;

        me.$el.html(me.sectionTpl(me.model.attributes));
        me.listenTo(me.model, "change", me.render);

        me.model.bind('activate', me.activatePage, me);
    },

    render: function () {
        this.$el.toggleClass('active', this.model.get('isActive'));
        return this;
    }

});

},{"./Section":35}]},{},[6])