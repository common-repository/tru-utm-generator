jQuery(document).ready(function (e) {
    // on - change
    jQuery('#utm_selected_domain').val(jQuery('#utm_domain').val());
    jQuery('#utm_domain').change(function (m) {
        var selectedDomain = jQuery(this).val();
        jQuery('#utm_selected_domain').val(selectedDomain);
    });
    var utm_ajax_url = tru_utm.ajaxurl;
    var tru_utm_nonce = tru_utm.nonce;
    jQuery('#tru_generate_utm').click(function (c) {
        c.preventDefault();
        jQuery('input[type=text],input[type=email]').css('border', '1px solid #ddd');
        var moveAhead = true;
        if (jQuery('#utm_fname').val() == '') {
            moveAhead = false;
            jQuery('#utm_fname').css('border', '1px solid red');
        }
        if (jQuery('#utm_email').val() == '') {
            moveAhead = false;
            jQuery('#utm_email').css('border', '1px solid red');
        }
        if (!mkTruValideEmail(jQuery('#utm_email').val())) {
            moveAhead = false;
            jQuery('#utm_email').css('border', '1px solid red');
        }
        if (jQuery('#utm_selected_domain').val() == '') {
            moveAhead = false;
            jQuery('#utm_selected_domain').css('border', '1px solid red');
        }
        if (jQuery('#utm_campaign').val() == '') {
            moveAhead = false;
            jQuery('#utm_campaign').css('border', '1px solid red');
        }
        if (moveAhead) {
            jQuery('#utm_email').css('border', '1px solid red');
            jQuery('#tru_generate_utm').text('Generating Please Wait..');
            jQuery.ajax({
                type: "POST",
                url: utm_ajax_url,
                data: {
                    action: 'tru_utm_url_generate',
                    utm_fname: jQuery('#utm_fname').val(),
                    utm_email: jQuery('#utm_email').val(),
                    utm_selected_domain: jQuery('#utm_selected_domain').val(),
                    utm_source: jQuery('#utm_source option:selected').val(),
                    utm_medium: jQuery('#utm_medium option:selected').val(),
                    utm_campaign: jQuery('#utm_campaign').val(),
                    utm_date: jQuery('#utm_date').val(),
                    nonce: tru_utm_nonce
                },
                cache: false,

                success: function (res) {
                    jQuery('#tru_generate_utm').text('Generate');
                    var resp = jQuery.parseJSON(res);
                    if (resp.error == '0') {
                        var generated_url = '<code>' + resp.response + '</code>';
                        jQuery('#tru_generated_utm').show().html(generated_url);
                        jQuery('input[type=text],input[type=email]').val('');
                    } else {
                        alert(resp.response);
                    }
                }
            });
        } else {
            alert('Some required fields are empty!')
        }
    });
    //dp
    jQuery("#utm_date").datepicker({
        dateFormat: "yymmdd"
    });

    function mkTruValideEmail(mail) {

        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(mail) == false) {
            return false;
        }

        return true;
    }
});