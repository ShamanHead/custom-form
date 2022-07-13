let button = $("#submit-form");

console.log("hello!");

button.on('click', () => {
   console.log("submitted"); 
    let form = $("custom-form"); 
    let data = {
        firstName: $("input[name=first_name]").val(),
        lastName: $("input[name=last_name]").val(),
        message: $("input[name=message]").val(),
        subject: $("input[name=subject]").val(),
        email: $("input[name=email]").val()
    }

    $.post("?custom-form&json", data, (data, status) => {
        let realData = JSON.parse(data),
            boxMessage = $(".box-message");
        
        switch(realData.code) {
            case 500:
                boxMessage.addClass("box-error");
                boxMessage.text("Please, fill all inputs");
                break;
            case 501:
                boxMessage.addClass("box-error");
                boxMessage.text("Email incorrect");
                break;
            case 502:
                boxMessage.addClass("box-error");
                boxMessage.text("Message could not be sent");
                break;
            case 200:
                boxMessage.addClass("box-ok");
                boxMessage.text("Ok");
                break;
        }
    });

})