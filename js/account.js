$(document).ready(function () {

    // let alerts disappear after some time
    $('.alert').fadeIn().delay(1000).fadeOut();

    // [ADD PAGE]

    // check if email already exists in the database
    $('#adminEmail').keyup(function () {
        var adminEmail = $(this).val()  //get email from user input
        $.ajax({
            type: "POST",
            url: "account_validate.php",
            data: { adminEmail: adminEmail },
            success: function (data) {
                if (!$.trim(data)) { // returns null means email does not exists in the database
                    $("#adminEmail").removeClass('is-invalid'); // remove red frame for input
                   // $('#save_btn').prop('disabled', false); // enable update button
                } else {
                    $("#adminEmail").addClass('is-invalid');  // show red frame for input 
                    $('#validate_email').html(data).css('color', 'red');  // display validation message
                    // $('#save_btn').prop('disabled', true);  // disabe update button
                }
            }
        });
    });


    // new password validation
    $('#password, #password_confirmed').keyup(function () {
        var password = $('#password').val();
        var password_confirmed = $('#password_confirmed').val();

        // check if password and confirmed password match
        if ((password === password_confirmed)) {
            $("#password_confirmed").removeClass('is-invalid'); // remove red frame for input
            $('#validate_password').empty(); // clear message
            $('#save_btn').prop('disabled', false); // enable update button
        }
        else {
            $("#password_confirmed").addClass('is-invalid');  // show red frame for input 
            $('#validate_password').html('New password not matching').css('color', 'red');  // show message
            $('#save_btn').prop('disabled', true);  // disabe update button
        }
    });

    // reset form and error message if user clicked on cancel button
    $('#close_btn_add').on('click', function () {
        $("#accountForm")[0].reset();  // clear form
        $('#validate_password').empty();  // clear password error message
        $("#adminEmail").removeClass('is-invalid');  // remove red frame for input 
        $("#password_confirmed").removeClass('is-invalid'); // remove red frame for input
    });


    // [Edit PAGE]

    // hide change password div by default
    $('#changePassword').hide();

    // verify old password
    $("#edit_password").click(function () {
        var password = $(this).val();
        $("#edit_password").val("");  // clear old password
        $("label[for='edit_password']").text("Old Password");  // change label text 

        $(this).keyup(function () {
            var retype = $("#edit_password").val();  // get user input
            // check if retyped password matches old password from the database 
            if (retype != "" && retype === password) {  // if macthes
                $("#edit_password").removeClass('is-invalid');  // remove red frame for input 
                $('#validate_password_old').empty(); // clear error
                $('#changePassword').show(); // show div to create new password 
                $("#password_new").prop('required', true);
                $("#password_confirmed_new").prop('required', true);  // add required attribute to new password
            } else {
                $('#changePassword').hide(); // hide change password div if not matching old password
                $("#edit_password").addClass('is-invalid');  // show red frame for input
                $('#validate_password_old').html('Old password not matched').css('color', 'red');
                $('#submit').prop('disabled', true);  // disabe update button
            }
        });
    });


    // new password validation
    $('#password_new, #password_confirmed_new').keyup(function () {

        var oldPassword = $("#edit_password").val();
        var newPassword = $('#password_new').val();
        var newPasswordConfirmed = $('#password_confirmed_new').val();

        // check if new password is the same as old password
        if (oldPassword === newPassword) {
            $("#password_new").addClass('is-invalid');  // show red frame for input 
            $('#validate_password_new').html('New password cannot be the same as old password').css('color', 'red'); // show message
            $('#submit').prop('disabled', true);  // disabe update button
        } else {
            $("#password_new").removeClass('is-invalid');  // remove red frame for input
            $('#validate_password_new').empty();  // clear message
        }

        // check if password and confirmed password match
        if ((newPassword === newPasswordConfirmed)) {
            $("#password_confirmed_new").removeClass('is-invalid');
            $('#validate_password_confirmed_new').empty(); // clear message
            $('#submit').prop('disabled', false); // enable update button
        }
        else {
            $("#password_confirmed_new").addClass('is-invalid');  // show red frame for input 
            $('#validate_password_confirmed_new').html('New password not matching').css('color', 'red');  // show message
            $('#submit').prop('disabled', true);  // disabe update button
        }
    });


});

