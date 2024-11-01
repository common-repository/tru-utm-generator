jQuery(window).load(function (e) {
    jQuery('.trutm').delay(10000).slideDown('slow');
});
jQuery(document).ready(function (e) {
    jQuery('.view_utm_link').click(function (e) {
        e.preventDefault();
        var data_link = jQuery(this).attr('data-link');
        jQuery('#view_utm_link').text(data_link);
        jQuery('.utm_view_popup_wrap').fadeIn();
    });

    jQuery('.close_utm_view_popup').click(function (e) {
        jQuery('.utm_view_popup_wrap').fadeOut();
    });
    jQuery(document).on('keyup', function (evt) {
        if (evt.keyCode == 27) {
            jQuery('.utm_view_popup_wrap').fadeOut();
        }
    });
    // dt
    jQuery('#tru_utm_records').DataTable();
    // close help  
    jQuery('.close_utm_help').on('click', function (e) {
        var what_to_do = jQuery(this).data('ct');
        jQuery.ajax({
            type: "post",
            url: ajaxurl,
            data: {
                action: "mk_tru_utm_generator_help",
                what_to_do: what_to_do
            },
            success: function (response) {
                jQuery('.trutm').slideUp('slow');
            }
        });
    });
});