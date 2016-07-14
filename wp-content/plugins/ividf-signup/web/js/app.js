jQuery(function() {
    jQuery.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
            && /[a-z]/.test(value) // has a lowercase letter
            && /[A-Z]/.test(value) // has a uppercase letter
            && /\d/.test(value) // has a digit
    });

    jQuery.validator.addMethod("previous", function(value) {
        return value != jQuery('.ivin-signup-form input[name=email]').attr('data-previous');
    });

    if(jQuery('input[name=worked_before]').is(':not(:checked)')){
        jQuery('.invention_ids_row').hide()
    }
    jQuery('input[name=worked_before]').on('change', function(){
        if(jQuery(this).is(':checked')) {
            jQuery('.invention_ids_row').show()
        } else {
            jQuery('.invention_ids_row').hide()
        }
    });

    var form = jQuery('.ivin-signup-form');

    form.validate({
        rules: {
            first_name: {
                required: true,
                rangelength: [2, 64]
            },
            last_name: {
                required: true,
                rangelength: [2, 64]
            },
            email: {
                required: true,
                email: true,
                previous: true,
                rangelength: [4, 128],
                remote: {
                    url: ivin_signup.url,
                    type: "post",
                    data: {
                        email: function() {
                            return jQuery("[name='email']").val();
                        },
                        action: "ivin_signup_email_check"
                    }
                }
            },
            home_country: {
                required: true
            },
            password: {
                required: true,
                pwcheck: true,
                rangelength: [8, 24]
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
            invention_ids: {
                required: function() {
                    return jQuery("input[name=worked_before]").is(':checked');
                }
            }
        },
        messages: {
            email: {
                previous: "Email is already taken",
                remote: "Email is already taken"
            },
            password: {
                pwcheck: "Must contain a lowercase character, uppercase character and a number"
            }
        }
    });
    if(jQuery('.ivin-signup-form input[name=email]').val()) {
        form.valid();
    }
});