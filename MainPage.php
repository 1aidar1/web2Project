<!DOCTYPE html>
<html lang="en">

<head>
    <title>MainPage</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            max-width: 99%;
        }

        div {
            outline: 0.5px red solid;
        }

        .header {
            background-color: aquamarine;
            padding-top: 0.5%;
            padding-bottom: 0.5%;
            z-index: 999;
        }

        .content {
            padding-top: 1%;
            padding-bottom: 1%;
        }

        .footer {
            background-color: aquamarine;
            padding-top: 0.5%;
            padding-bottom: 0.5%;
        }

        #blanket {
            display: none;
            position: absolute;
            top: 7%;
            left: 0;
            width: 100%;
            height: 93%;
            background-color: LightGrey;
            opacity: 0.5;
            z-index: 1;

        }

        .modal-window {
            display: none;
            width: 400px;
            height: 300px;
            outline: 2px solid black;
            background-color: white;
            position: fixed;
            top: calc(50% - 150px);
            left: calc(50% - 200px);
            z-index: 9999;
            clear: both;
        }

        .modal-window label {
            display: inline-block;
            margin-left: 15px;
            width: 75px;
        }

        .modal-window input {
            width: 140px;
        }
        
        form div {
            margin-bottom: 15px;
        }
        form button {
            margin-left: 10px;
        }

    </style>
</head>

<body>
    <div class="contaier-fluid">
        <div class="row header">
            <div class="col-md-10">

            </div>
            <div id="div-unsigned">
                <div class="col-md-1">
                    <button class="btn btn-default" id='btn-register'>Register</button>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-default" id='btn-login'>Login</button>
                </div>
            </div>

        </div>

        <div class="row content">

            <div id='blanket'></div>

            <!-- SignIn modal window-->
            <div class='modal-window' id="sign-in-modal">
                <h2 style='text-align:center'>Sign In</h2>
                <br>
                <form action="controller.php" method="POST" id="form-signin" name="form-signin">
                    <div>
                        <label for="signin-username">Username: </label>
                        <input type="text" name="username" id="signin-handle" required>
                    </div>

                    <div>
                        <label for="signin-password">Password: </label>
                        <input type="password" name="password" id="signin-password" required>
                    </div>

                    <div>
                        <input type="text" name="page" id="page" value="StartPage"
                            style="visibility: hidden; position: absolute;">
                        <input type="text" name="command" id="signin" value="SignIn"
                            style="visibility: hidden; position: absolute;">
                        <button type="button" id="btn-form-signin" name="signin-submit">Submit</button>
                        <button type="button" id="btn-cancel-signin"> Cancel</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </div>

            <!-- Register modal window-->
            <div class='modal-window' id="register-modal">
                <h2 style='text-align:center'>Register</h2>
                <br>
                <form action="controller.php" method="POST" id="form-join" name="form-join">
                    <div>
                        <label for="join-username">UIN: </label>
                        <input type="text" name="UIN" required id="register-UIN">
                    </div>
                    <div>
                        <label for="join-username">Handle: </label>
                        <input type="text" name="username" required id="register-handle">
                    </div>

                    <div>
                        <label for="join-password">Password: </label>
                        <input type="password" name="password" required id="register-password">
                    </div>

                    <div>
                        <label for="join-email">Phone: </label>
                        <input type="text" name="tel" id="register-tel" required>
                    </div>

                    <div>
                        <input type="text" name="page" id="page2" value="StartPage"
                            style="visibility: hidden; position: absolute;">
                        <input type="text" name="command" id="join" value="Join"
                            style="visibility: hidden; position: absolute;">

                        <button type="button" id="btn-form-register" name="join-submit">Submit</button>
                        <button type="button" id="btn-cancel-register">Cancel</button>
                        <button type="reset">Reset</button>
                    </div>
                </form>
            </div>

        </div>

        <div class="row footer">

        </div>
    </div>
</body>
<script>

    $('#btn-form-signin').click(() => {
        var url = 'controller.php';
        var query = {
            page: 'MainPage',
            command: 'SignIn',
            handle: $('#signin-handle').val(),
            password: $('#signin-password').val()
        };
        // jQuery post
        $.post(url, query, function (data, status) {
            var d = JSON.parse(data);
            if(d.display == 'signed'){

            }
            alert(d.display);
            
        });
    });

    $('#btn-form-register').click(() => {
        var url = 'controller.php';
        var query = {
            page: 'MainPage',
            command: 'Register',
            UIN: $('#register-UIN').val(),
            handle: $('#register-handle').val(),
            password: $('#register-password').val(),
            tel: $('#register-tel').val()
        };
        // jQuery post
        $.post(url, query, function (data, status) {
            alert(data);
        });
    });


    $('#btn-cancel-signin').click(() => {
        hide();
    });
    $('#btn-cancel-register').click(() => {
        hide();
    });
    $('#blanket').click(() => {
        hide();
    });

    function hide() {
        $('#register-modal').css('display', 'none');
        $('#sign-in-modal').css('display', 'none');
        $('#blanket').css('display', 'none');
    }

    $('#btn-register').click(() => {

        $('#register-modal').css('display', 'block');
        $('#sign-in-modal').css('display', 'none');
        $('#blanket').css('display', 'block');
    });

    $('#btn-login').click(() => {

        $('#sign-in-modal').css('display', 'block');
        $('#register-modal').css('display', 'none');
        $('#blanket').css('display', 'block');
    });
</script>

</html>