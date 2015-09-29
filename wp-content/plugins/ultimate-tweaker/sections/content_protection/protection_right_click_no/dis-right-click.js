(function ($) {
    window.addEventListener('contextmenu', function (e) {
        var t = e || window.event;
        var n = t.target || t.srcElement;
        if (n.nodeName != "A")
            e.preventDefault();
    }, false);
    document.addEventListener("contextmenu", function (e) {
        var t = e || window.event;
        var n = t.target || t.srcElement;
        if (n.nodeName != "A")
            e.preventDefault();
    }, false);
})(jQuery);