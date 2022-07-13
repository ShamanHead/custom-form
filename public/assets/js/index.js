let button = jQuery("#submit-form");

button.on('click', () => {
   console.log("submitted"); 
    let form = jQuery("custom-form"); 
    let data = {
        action: "form_submit",
        data: {
                firstName: jQuery("input[name=first_name]").val(),
                lastName: jQuery("input[name=last_name]").val(),
                message: jQuery("input[name=message]").val(),
                subject: jQuery("input[name=subject]").val(),
                email: jQuery("input[name=email]").val()
            }
    }

    jQuery.post(AjaxObject.ajaxUrl, data, (data, status) => {
        let realData = JSON.parse(data),
            message = '';

        switch(realData.code) {
            case 500:
                Notiflix.Notify.warning( 
                  'Fill all fields please.'
                );
                break;
            case 501:
                Notiflix.Notify.warning( 
                  'E-mail is incorrect'
                );
                break;
            case 502:
                Notiflix.Notify.warning(
                  'Message not sent'
                );
                break;
            case 200:
                Notiflix.Notify.success(
                  'Message sent'
                );
                break;
        }
    });

})
