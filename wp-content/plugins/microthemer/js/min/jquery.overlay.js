// Microthemer - v3.7.5 (2015-09-25)
try{window.parent.TvrSharedVars&&(!function(a){a.fn.extend({add_overlay:function(b){var c=this.length;c>19&&(c=19);var d=["left","top","right","bottom"],e={padding:!0,margin:!0,border:!0,content:!0},b=a.extend(e,b);return this.each(function(e){if(e>c)return!1;var f=window.TvrExportVars.overlayCount,g=this,h=a(this);if(!a(this).hasClass("tvr-element-overlay")&&a(this).is(":visible")){a(this).addClass("tvr-element-overlay"),a(this).hasClass("tvr-hover-overlay")||a(this).addClass("tvr-static-overlay");var i={},j=parseInt(h.css("font-size")),k=a(this).offset();if(k.top=k.top+parseInt(h.css("border-top-width")),k.left=k.left+parseInt(h.css("border-left-width")),window.parent.TvrSharedVars.highlightEnabled)var l="";else var l="display:none;";a("body").prepend('<div id="over-cont-'+f+'" class="tvr-overlay tvr-container-overlay" style="width:'+a(this).innerWidth()+"px;height:"+a(this).innerHeight()+"px;"+l+'"></div>');var m=a("#over-cont-"+f);if(a(this).hasClass("tvr-hover-overlay")&&m.mouseleave(function(){m.remove(),a(g).removeClass("tvr-element-overlay tvr-hover-overlay")}),m.offset({top:k.top,left:k.left}),b.margin){m.append('<div class="tvr-overlay tvr-margin-overlay"></div>');for(s in d){var n=0-parseInt(h.css("margin-"+d[s]))-parseInt(h.css("border-"+d[s]+"-width"));i[d[s]]=n/j+"em"}m.find(".tvr-margin-overlay").css(i)}if(b.border&&(m.append('<div class="tvr-overlay tvr-border-overlay"></div>'),m.find(".tvr-border-overlay").css({top:0-parseInt(h.css("border-top-width"))/j+"em",right:0-parseInt(h.css("border-right-width"))/j+"em",bottom:0-parseInt(h.css("border-bottom-width"))/j+"em",left:0-parseInt(h.css("border-left-width"))/j+"em"})),b.padding&&m.append('<div class="tvr-overlay tvr-padding-overlay"></div>'),b.content){m.append('<div class="tvr-overlay tvr-content-overlay"></div>'),i={};for(s in d)i[d[s]]=parseInt(h.css("padding-"+d[s]))/j+"em";m.find(".tvr-content-overlay").css(i)}window.TvrExportVars.overlayCount++}})}})}(jQuery),LazyLoad=function(a){function b(b,c){var d,e=a.createElement(b);for(d in c)c.hasOwnProperty(d)&&e.setAttribute(d,c[d]);return e}function c(a){var b,c,d=j[a];d&&(b=d.callback,c=d.urls,c.shift(),k=0,c.length||(b&&b.call(d.context,d.obj),j[a]=null,l[a].length&&e(a)))}function d(){var b=navigator.userAgent;h={async:a.createElement("script").async===!0},(h.webkit=/AppleWebKit\//.test(b))||(h.ie=/MSIE|Trident/.test(b))||(h.opera=/Opera/.test(b))||(h.gecko=/Gecko\//.test(b))||(h.unknown=!0)}function e(e,k,m,n,o){var p,q,r,s,t,u,v=function(){c(e)},w="css"===e,x=[];if(h||d(),k)if(k="string"==typeof k?[k]:k.concat(),w||h.async||h.gecko||h.opera)l[e].push({urls:k,callback:m,obj:n,context:o});else for(p=0,q=k.length;q>p;++p)l[e].push({urls:[k[p]],callback:p===q-1?m:null,obj:n,context:o});if(!j[e]&&(s=j[e]=l[e].shift())){for(i||(i=a.head||a.getElementsByTagName("head")[0]),t=s.urls.concat(),p=0,q=t.length;q>p;++p)u=t[p],w?r=h.gecko?b("style"):b("link",{href:u,rel:"stylesheet"}):(r=b("script",{src:u}),r.async=!1),r.className="lazyload",r.setAttribute("charset","utf-8"),h.ie&&!w&&"onreadystatechange"in r&&!("draggable"in r)?r.onreadystatechange=function(){/loaded|complete/.test(r.readyState)&&(r.onreadystatechange=null,v())}:w&&(h.gecko||h.webkit)?h.webkit?(s.urls[p]=r.href,g()):(r.innerHTML='@import "'+u+'";',f(r)):r.onload=r.onerror=v,x.push(r);for(p=0,q=x.length;q>p;++p)i.appendChild(x[p])}}function f(a){var b;try{b=!!a.sheet.cssRules}catch(d){return k+=1,void(200>k?setTimeout(function(){f(a)},50):b&&c("css"))}c("css")}function g(){var a,b=j.css;if(b){for(a=m.length;--a>=0;)if(m[a].href===b.urls[0]){c("css");break}k+=1,b&&(200>k?setTimeout(g,50):c("css"))}}var h,i,j={},k=0,l={css:[],js:[]},m=a.styleSheets;return{css:function(a,b,c,d){e("css",a,b,c,d)},js:function(a,b,c,d){e("js",a,b,c,d)}}}(this.document),window.TvrExportVars={},jQuery(document).ready(function(a){parseInt(a("#mt-show-admin-bar").attr("content"))||a("html").addClass("no-admin-bar-please"),a(window).keypress(function(a){return 115==a.which&&a.ctrlKey||19==a.which?(a.preventDefault(),!1):!0}),a(document).keydown(function(a){return 83==a.which&&1==a.ctrlKey?(window.parent.TvrSharedVars.ajax_save_settings("save"),a.preventDefault(),!1):void 0}),window.parent.TvrSharedVars.progCount>0&&window.parent.TvrSharedVars.update_prog_indicator("minus");var b=[],c={stylesheetUrl:"",init:function(){c.stylesheetUrl=a("#microthemer-css").attr("href"),c.stylesheetUrl||(c.stylesheetUrl=a('link[href*="\\/micro-themes\\/"]').attr("href")),window.TvrExportVars.iframe_window_fully_loaded=!0},refreshCSS:function(){var b=a("head").find(".lazyload"),d=c.stylesheetUrl.replace(/\?.*|$/,"?reload="+(new Date).getTime());if(window.parent.TvrSharedVars.g_url)var e=window.parent.TvrSharedVars.g_url+"&reload="+(new Date).getTime(),f=[d,e],g=a("#microthemer_g_font-css");else var f=d,g=a("#tvr-no-sheet");LazyLoad.css(f,function(){var d=a("#microthemer-css").add(g);d&&d.remove(),b&&b.remove(),c.get_computed_styles(window.parent.TvrSharedVars.curSelCSS,"str"),window.parent.TvrSharedVars.refresh_comp_css(),c.update_highlight("reg"),window.parent.TvrSharedVars.progCount>0&&window.parent.TvrSharedVars.update_prog_indicator("minus")},"hello")},clean_classes:function(a){return a=a.replace("  "," ").replace("tvr-crosshair","").replace("  "," ").replace("tvr-element-overlay","").replace("  "," ").replace("tvr-static-overlay","").replace("  "," "),a.replace(/^\s+|\s+$/g,"")},initialEl:{},build_selector_suggestions:function(a){c.initialEl=a;for(var d in b)delete b[d];var e={};e.a={},e.a[":visited"]="visited link",e.a[":active"]="active state link",e.a[":hover"]="hover state link";var f=a.prop("tagName").toLowerCase();if("input"==f)var g=a.attr("type");var h=a.attr("id"),i=a.attr("class");i&&(i=c.clean_classes(i));var j=a.parent().not("html"),k=0,l="",m=[],n=-1,o="&#60;"+f;"input"==f&&(o+=" type="+g);var p=js_i18n_overlay.element_type_target;if(b[p]=[],"input"==f)b[p][f+"[type="+g+"]"]="<"+f+"> "+js_i18n_overlay.elements_of_type+" '"+g+"'";else if("a"==f)for(var q in e[f])b[p][f+q]="<"+f+">s ("+e[f][q]+")";if(b[p][f]=tvrsprintf(js_i18n_overlay.all_elements,f),++k,i){o+=' class="'+i+'"',p=js_i18n_overlay.element_class_target,b[p]=[];for(var r=i.split(" "),s=0;s<r.length;s++){if(l=f+"."+r[s],"a"==f)for(var q in e[f])b[p][l+q]="<"+f+"> "+js_i18n_overlay.elements_of_class+" '"+r[s]+"' ("+e[f][q]+")";b[p][l]="<"+f+"> "+js_i18n_overlay.elements_of_class+" '"+r[s]+"'",0==s&&(m[++n]=l)}var t=!0,u=!0;++k}if(j.prop("tagName")){var v=c.find_parent_attributes(j,"class");if(v){p=js_i18n_overlay.parent_class_target,b[p]=[];for(var w=v.prop("tagName").toLowerCase(),x=c.clean_classes(v.attr("class")),y=x.split(" "),s=0;s<y.length;s++){if(l=w+"."+y[s]+" "+f,"a"==f)for(var q in e[f])b[p][l+q]=tvrsprintf(js_i18n_overlay.parent_class_target_desc,f,w,y[s])+"' ("+e[f][q]+")";b[p][l]=tvrsprintf(js_i18n_overlay.parent_class_target_desc,f,w,y[s])+"'",u||0!=s||(m[++n]=l)}var z=!0;++k}}if(t&&z){p=js_i18n_overlay.parent_element_class_target,b[p]=[];for(var s=0;s<y.length;s++)for(var A=0;A<r.length;A++){if(l=w+"."+y[s]+" "+f+"."+r[A],"a"==f)for(var q in e[f])b[p][l+q]=tvrsprintf(js_i18n_overlay.parent_element_class_target_desc,f,r[A],w,y[s])+"' ("+e[f][q]+")";b[p][l]=tvrsprintf(js_i18n_overlay.parent_element_class_target_desc,f,r[A],w,y[s]),0==s&&(m[++n]=l)}++k}if(window.parent.TvrSharedVars.hasValue(h)){if(o+=' id="'+h+'"',p=js_i18n_overlay.element_id_target,b[p]=[],l=f+"#"+h,"a"==f)for(var q in e[f])b[p][l+q]=tvrsprintf(js_i18n_overlay.element_id_target_desc,f,h)+" ("+e[f][q]+")";b[p][l]=tvrsprintf(js_i18n_overlay.element_id_target_desc,f,h),m[++n]=l;var B=!0,C=!0;++k}if(j.prop("tagName")){var D=c.find_parent_attributes(j,"id");if(D){p=js_i18n_overlay.parent_id_target,b[p]=[];var E=D.prop("tagName").toLowerCase(),F=D.attr("id");if(l=E+"#"+F+" "+f,"a"==f)for(var q in e[f])b[p][l+q]=tvrsprintf(js_i18n_overlay.parent_id_target_desc,f,E,F)+" ("+e[f][q]+")";b[p][l]=tvrsprintf(js_i18n_overlay.parent_id_target_desc,f,E,F),C||(m[++n]=l);var G=!0;++k}}if(t&&G){p=js_i18n_overlay.parent_id_element_class_target,b[p]=[];for(var A=0;A<r.length;A++){if(l=E+"#"+F+" "+f+"."+r[A],"a"==f)for(var q in e[f])b[p][l+q]=tvrsprintf(js_i18n_overlay.parent_id_element_class_target_desc,f,r[A],E,F)+" ("+e[f][q]+")";b[p][l]=tvrsprintf(js_i18n_overlay.parent_id_element_class_target_desc,f,r[A],E,F),0==A&&(m[++n]=l)}++k}if(B&&G){if(p=js_i18n_overlay.parent_element_id_target,b[p]=[],l=E+"#"+F+" "+f+"#"+h,"a"==f)for(var q in e[f])b[p][l+q]=tvrsprintf(js_i18n_overlay.parent_element_id_target_desc,f,h,E,F)+" ("+e[f][q]+")";b[p][l]=tvrsprintf(js_i18n_overlay.parent_element_id_target_desc,f,h,E,F),m[++n]=l,++k}window.parent.TvrSharedVars.intelli_css=n>-1?l:f,b.Intelli=[],b.Intelli.ogCount=k;var H=a.children().not(".tvr-container-overlay, script").filter(":first"),I=a.prevAll().not(".tvr-container-overlay, script, head").filter(":first"),J=a.nextAll().not(".tvr-container-overlay, script").filter(":first");b.Intelli.parent=j.prop("tagName")?j:!1,b.Intelli.child=H.prop("tagName")?H:!1,b.Intelli.prev=I.prop("tagName")?I:!1,b.Intelli.next=J.prop("tagName")?J:!1,o=c.finish_tag_string(f,o),b.Intelli.htmlString=o,c.update_highlight("intelli"),window.parent.TvrSharedVars.highlightEnabled||(window.parent.TvrSharedVars.tmpHighlighting=!0,window.parent.TvrSharedVars.toggle_highlighting()),window.parent.TvrSharedVars.TvrSugCSS=b,c.get_computed_styles(a,"obj",!0),window.parent.TvrSharedVars.intelli?window.parent.TvrSharedVars.update_selector_wizard():window.parent.TvrSharedVars.show_wizard()},finish_tag_string:function(a,b){return b+="area"!=a&&"base"!=a&&"br"!=a&&"col"!=a&&"command"!=a&&"embed"!=a&&"hr"!=a&&"img"!=a&&"input"!=a&&"meta"!=a&&"param"!=a&&"source"!=a?"&#62;...&#60;/"+a+"&#62;":" /&#62;"},find_parent_attributes:function(a,b){return a.attr(b)&&c.clean_classes(a.attr(b))?a:(a=a.parent().not("html"),a.prop("tagName")?c.find_parent_attributes(a,b):!1)},allocateOverlayMode:function(){},format_mixed_array:function(a,b){for(var d={},e=0;e<a.length;e++){var f=b[e].atts,g="&#60;"+f.type;f.id&&(g+=' id="'+f.id+'"'),f["class"]&&(f["class"]=f["class"].replace("tvr-element-overlay","").replace("tvr-static-overlay","").replace("  "," "),/\S/.test(f["class"])&&(g+=' class="'+f["class"]+'"')),g=c.finish_tag_string(f.type,g),d[e]=[],d[e].val=a[e],d[e].htmlString=g}return d},compProps:{},clean_selector:function(a){a=a.replace(/:hover/g,"").replace(/:active/g,"").replace(/:visited/g,"").replace(/:link/g,"").replace(/::before/g,"").replace(/:before/g,"").replace(/::after/g,"").replace(/:after/g,""),a=window.parent.TvrSharedVars.custom_to_non_escaped(window.parent.TvrSharedVars.jquery_escape_quotes(a));var b=window.parent.TvrSharedVars.analyse_sel_code(a);return b.code},flatten:function(a){var b=[],c=-1;for(var d in a)if("[object Array]"===Object.prototype.toString.call(a[d]))for(var e in a[d])b[++c]=a[d][e];return b},flatten_better:function(b){var c=[],d=-1;for(var e in b)if(a.isArray(b[e]))for(var f in b[e])c[++d]=b[e][f];return c},sel_elements:{},get_computed_styles:function(b,d,e){if("str"==d){b=c.clean_selector(b);var f=a("#wpadminbar"),g=a(b).not(f).not(f.find(b))}else var g=c.initialEl;if(c.sel_elements=g,!g.length)return window.parent.TvrSharedVars.compProps={},!1;if(""==window.parent.TvrSharedVars.pgInFocus||e)var h=c.flatten(window.parent.TvrSharedVars.cssProps);else var h=window.parent.TvrSharedVars.cssProps[window.parent.TvrSharedVars.pgInFocus];var i=g.length;i>19&&(i=19);var j={ltr:{start:"left",end:"right",webkitauto:"left"},rtl:{start:"right",end:"left",webkitauto:"right"}},k=[],l=[];c.compProps={};var m=0,n=jQuery.fn.jquery.split(".").map(function(a){return("0"+a).slice(-2)}).join(".");n=n.toString(),g.each(function(b){if(++m,b>i)return!1;k[b]=[];var c=a(this);if(n>="01.09.00")var d=c.css(h);else{var d={"font-family":""};window.parent.TvrSharedVars.log([js_i18n_overlay.update_jquery,"<p>"+js_i18n_overlay.update_jquery_long+"</p>"]),window.parent.TvrSharedVars.update_full_logs()}for(var e in d)if(window.parent.TvrSharedVars.hasValue(d[e])){if("text-align"!=e||"start"!=d[e]&&"end"!=d[e]){if("text-align"==e&&"-webkit-auto"==d[e])d[e]=j[d.direction][d[e].replace(/-/g,"")];else if("text-decoration"==e){var f=d[e].split(" ");d[e]=f[0]}}else;if(d[e]=window.parent.TvrSharedVars.sane_decimal(d[e]),"background-position"==e||"background-repeat"==e||"background-attachment"==e){var f=d[e].split(",");d[e]=f[0]}"background-image"==e&&(d["background-img-full"]=d[e],d["extracted-gradient"]=window.parent.TvrSharedVars.extract_str("gradient",d[e]),d[e]=window.parent.TvrSharedVars.extract_str("bg-image",d[e]));var g=c.parent();l[b]=[],l[b].element={},window.parent.TvrSharedVars.isDomEl(g)?(l[b].parent=g.css(["font-size","width","height"]),l[b].element["font-size"]=c.css("font-size")):l[b].element["font-size"]=c.css("font-size")}k[b].propsList=d,k[b].atts=[],k[b].atts.type=c.prop("tagName").toLowerCase(),k[b].atts.id=c.attr("id"),k[b].atts["class"]=c.attr("class")});for(var o in h){var p=h[o],q=k[0].propsList[p],r=new Array,s=!1;for(var t in k)k[t].propsList&&(r[t]=k[t].propsList[p],r[t]!=q&&(s=!0));c.compProps[p]=s?c.format_mixed_array(r,k):q}e?(window.parent.TvrSharedVars.intelliCompProps=c.compProps,window.parent.TvrSharedVars.intellinodeCSS=l):(window.parent.TvrSharedVars.compProps=c.compProps,window.parent.TvrSharedVars.nodeCSS=l)},update_highlight:function(b,d){if(a(".tvr-container-overlay").remove(),a(".tvr-element-overlay").removeClass("tvr-element-overlay tvr-static-overlay"),"reg"==b)var e=c.clean_selector(window.parent.TvrSharedVars.curSelCSS);else if("intelli"==b||"sel-preview"==b)var e=c.clean_selector(window.parent.TvrSharedVars.intelli_css);window.TvrExportVars.overlayCount=0;try{if("mixed-hover"!=b)var f=a("#wpadminbar"),g=a(e).not(f).not(f.find(e)),h=g.first();else var g=c.sel_elements.eq(window.parent.TvrSharedVars.mixedElKey),h=g;("mixed-hover"==b||"sel-preview"==b||d)&&a("html, body").animate({scrollTop:h.offset().top-36},250),g.add_overlay()}catch(i){}},showOverlays:function(){a(".tvr-container-overlay").show()},hideOverlays:function(){a(".tvr-container-overlay").hide()},singleClick:function(a,b,c,d,e,f){b.preventDefault();var g="";return"a"==c?g=a.attr("href"):f&&(g=e.attr("href")),g.match(/\.(gif|jpe?g|png|svg)$/i)?!1:void setTimeout(function(){var b=parseInt(a.data("double"),10);if(b>0){if(a.data("double",b-1),f)return!1}else if("a"==c||f)g.indexOf(window.parent.TvrSharedVars.adminUrl)>-1&&(window.parent.location=g),window.location=g;else if("submit"==d){var e=a.closest("form");window.parent.TvrSharedVars.isDomEl(e)&&e.trigger("submit")}},700)}};a("body").on("mouseup",function(){window.parent.TvrSharedVars.colorPickerDragging&&window.parent.TvrSharedVars.picker_method("clickpick")}),a("body").click(function(b){var d=a(b.target);window.parent.TvrSharedVars.close_all_expanded(d,"");var e=d.closest("a"),f=!1;if(window.parent.TvrSharedVars.isDomEl(e))var f=!0;var g=d.prop("tagName").toLowerCase(),h=d.attr("type");h&&(h=h.toLowerCase()),("a"==g||f||"submit"==h)&&c.singleClick(d,b,g,h,e,f)}).dblclick(function(b){b.preventDefault();var d=a(b.target);if(d.data("double",2),d.hasClass("tvr-overlay")){if(window.parent.TvrSharedVars.intelli){js_i18n_overlay.wizard_mode}else{js_i18n_overlay.regular_mode}return window.parent.TvrSharedVars.hide_wizard(),!1}window.parent.TvrSharedVars.show_interface||window.parent.TvrSharedVars.show_interface_feature(!1,"interface");c.build_selector_suggestions(d)}),window.TvrExportVars.update_highlight=c.update_highlight,window.TvrExportVars.showOverlays=c.showOverlays,window.TvrExportVars.hideOverlays=c.hideOverlays,window.TvrExportVars.build_selector_suggestions=c.build_selector_suggestions,window.TvrExportVars.refreshCSS=c.refreshCSS,window.TvrExportVars.get_computed_styles=c.get_computed_styles,window.TvrExportVars.iframe_window_fully_loaded=!1,a(window).load(function(){c.init();var a="reg";window.parent.TvrSharedVars.intelli&&(a="intelli"),c.update_highlight(a),window.parent.TvrSharedVars.awaitingIframeReloadAfterSave?(c.refreshCSS(),window.parent.TvrSharedVars.awaitingIframeReloadAfterSave=!1):(c.get_computed_styles(window.parent.TvrSharedVars.curSelCSS,"str",window.parent.TvrSharedVars.intelli),window.parent.TvrSharedVars.refresh_comp_css()),window.parent.TvrSharedVars.remember_page_viewed()})}))}catch(e){}