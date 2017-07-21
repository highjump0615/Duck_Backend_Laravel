$(document).ready(function() {

    var base_url = 'http://localhost/';

    // show register form
    $('#create_account a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
    // show signin form
    $('#signin a').click(function(){
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });
    // show forgot form
    $('#forgot a').click(function(){
        //$('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });

    // register new administrator
    $('#regAdmin').click(function(){
        var params = {
            admin_name: $('#admin_name').val(),
            admin_pwd: $('#admin_pwd').val(),
            admin_email: $('#admin_email').val()
        }; 
        var url = base_url + 'login/register';
        console.log(params);
        $.ajax({
            type: "POST",
            url: url,
            data: params,
            dataType: 'json',
            success: function(result) {
                if(result == false) {
                    console.log(result);
                } else {
                    location.reload();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
});