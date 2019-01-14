$(function() {

    // Hide navbar with Headroom.js library
    $(".navbar-fixed-top").headroom({
        classes: {
            pinned: "headroom-top-pinned",
            unpinned: "headroom-top-unpinned"
        },
        offset: $('.navbar').outerHeight(),

        // callback when unpinned, `this` is headroom object
        onUnpin: function() {
            $('.navbar .dropdown-menu').parent().removeClass('open');
        }
    });

});