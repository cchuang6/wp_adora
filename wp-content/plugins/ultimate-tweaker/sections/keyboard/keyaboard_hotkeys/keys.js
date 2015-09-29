(function($) {
    Mousetrap.bindGlobal('mod u t', function(e) {
        window.location = 'admin.php?page=ultimate-tweaker';
        return false;
    });
    Mousetrap.bindGlobal('mod+. l', function(e) {
        window.location = 'edit.php?post_type=page';
        return false;
    });
    Mousetrap.bindGlobal('mod+. n', function(e) {
        window.location = 'post-new.php?post_type=page';
        return false;
    });
    Mousetrap.bindGlobal('mod+, l', function(e) {
        window.location = 'edit.php';
        return false;
    });
    Mousetrap.bindGlobal('mod+, n', function(e) {
        window.location = 'post-new.php';
        return false;
    });
    Mousetrap.bindGlobal('mod+, c', function(e) {
        window.location = 'edit-tags.php?taxonomy=category';
        return false;
    });
    Mousetrap.bindGlobal('mod+, t', function(e) {
        window.location = 'edit-tags.php?taxonomy=post_tag';
        return false;
    });
//    Mousetrap.bindGlobal('mod+m m', function(e) {
//        window.location = 'upload.php';
//        return false;
//    });
//    Mousetrap.bindGlobal('mod+m u', function(e) {
//        window.location = 'media-new.php';
//        return false;
//    });
    Mousetrap.bindGlobal('mod+s', function(e) {
        $('#publish').click();
        return false;
    });
    Mousetrap.bindGlobal('mod+shift+s', function(e) {
        $('#save-post').click();
        return false;
    });
    Mousetrap.bindGlobal('mod+q', function(e) {
        $('#post-preview').click();
        return false;
    });


//    Mousetrap.bindGlobal('f1', function(e) {
//        alert('help!')
//        return false;
//    });
    Mousetrap.bindGlobal('mod+m', function(e) {
        window.location = 'nav-menus.php';
        return false;
    });
    Mousetrap.bindGlobal('mod+y l', function(e) {
        window.location = 'users.php';
        return false;
    });
    Mousetrap.bindGlobal('mod+y n', function(e) {
        window.location = 'user-new.php';
        return false;
    });
    Mousetrap.bindGlobal('mod+b', function(e) {
        window.location = 'edit-comments.php';
        return false;
    });
    Mousetrap.bindGlobal('mod+shift+m', function(e) {
        window.open('nav-menus.php');
        return false;
    });


    Mousetrap.bindGlobal('mod+i p', function(e) {
        window.location = 'plugin-install.php';
        return false;
    });
    Mousetrap.bindGlobal('mod+i t', function(e) {
        window.location = 'theme-install.php';
        return false;
    });

    Mousetrap.bindGlobal('mod+i u', function(e) {
        window.location = 'plugin-install.php?tab=upload';
        return false;
    });
    Mousetrap.bindGlobal('mod+shift+l', function(e) {
        window.location = $('#wp-admin-bar-logout a').prop('href');
        return false;
    });
//    Mousetrap.bindGlobal('alt+p', function(e) {
//        alert('d')
//        return false;
//    });

    Mousetrap.bindGlobal('mod+i y', function(e) {
        window.location = 'theme-install.php?upload';
        return false;
    });

    $(function() {


//        window.location = 'edit.php';
    });
})(jQuery);