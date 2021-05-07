jQuery(document).ready(function ($) {
    $("#uname, #sq, #sa").on("keypress", function (event) {
        var regex = new RegExp("^[a-zA-Z0-9 ]+$");
        var key = String.fromCharCode(
            !event.charCode ? event.which : event.charCode
        );
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $("#email").on("keypress", function (event) {
        var regex = new RegExp("^[a-zA-Z0-9@. ]+$");
        var key = String.fromCharCode(
            !event.charCode ? event.which : event.charCode
        );
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $("#passwd").on("keypress", function (event) {
        var regex = new RegExp("^[a-zA-Z0-9$#@_ ]+$");
        var key = String.fromCharCode(
            !event.charCode ? event.which : event.charCode
        );
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

    $("#submit").click(function () {
        var email = $("#email").val();
        var uname = $("#uname").val();
        var passwd = $("#passwd").val();
        var sq = $("#sq").val();
        var sa = $("#sa").val();
        if (email == "") {
            alert("Please enter email id to continue.");
        } else if (email.trim() != "" && !IsEmail(email.trim())) {
            alert("Invalid Email");
        } else if (uname == "") {
            alert("Please enter user name to continue.");
        } else if (passwd == "") {
            alert("Please enter password to continue.");
        } else if (sq == "") {
            alert("Please enter security question to continue.");
        } else if (sa == "") {
            alert("Please enter security answer to continue.");
        } else {
            var data = {
                action: "dm_register_user",
                email: $("#email").val(),
                uname: uname,
                passwd: passwd,
                sq: sq,
                sa: sa,
                gresponse: grecaptcha.getResponse(),
            };
            $.post(my_ajax_object.ajax_url, data, function (response) {
                console.log("response = " + response);
                var data = JSON.parse(response);
                if (data.status == "success") {
                    $("#email, #uname, #passwd, #sq, #sa").val("");
                    grecaptcha.reset();
                    alert("User registered successfully.");
                } else if (data.status == "error") {
                    alert(data.error);
                }
            });
        }
    });
});

function IsEmail(a) {
    var b = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return b.test(a);
}
