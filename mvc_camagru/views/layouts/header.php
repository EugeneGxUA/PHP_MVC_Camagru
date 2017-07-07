
<?php
$session = Session::getInstance();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>Camagru</title>
    <link rel="stylesheet" href="/mvc_camagru/templates/css/index.css">


  <link rel="stylesheet" href="/mvc_camagru/templates/css/gallery.css">
    <link href="https://fonts.googleapis.com/css?family=Abel|Cinzel|Milonga|Josefin+Sans|Satisfy|Love+Ya+Like+A+Sister|Libre+Franklin|Open+Sans+Condensed:300" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
<body>

<nav>
    <div class="wrapper">
        <div class="logo"></div>
        <ul class="menu clearfix">
            <li class="btn-2">
                <a href="http://localhost:8080/mvc_camagru/">
                    <i class="fa fa-home" aria-hidden="true"></i>
                    <span>Home</span>
                </a>
            </li>

            <?php echo ($session->logged_user != "" ? " 

            <li class=\"btn-2\">
                <a id=\"logout_href\" href='http://localhost:8080/mvc_camagru/autorization_logout'>
                    <i class=\"fa fa-sign-out\" aria-hidden=\"true\"></i>  
                    <span>Log Out</span>
                </a>
            </li>" :
                "
            <li class=\"btn-2\">
                <a id=\"login_href\" href=\"#\">
                    <i class=\"fa fa-sign-in\" aria-hidden=\"true\"></i>
                    <span>Log In</span>
                </a>
            </li>
            <li class=\"btn-2\">
                <a id=\"signup_href\" href=\"#\">
                    <i class=\"fa fa-user-plus\" aria-hidden=\"true\"></i>
                    <span>Sign Up</span>
                </a>
            </li>");?>
            <?php if ($session->logged_user != ""){echo "
            <li class=\"btn-2\">
                <a id=\"modify_href\" href=\"#\">
                    <i class=\"fa fa-cogs\" aria-hidden=\"true\"></i>
                        <span>Modify</span>
                   </a>
               </li>
            <li class=\"btn-2\">
                <a href=\"photo_room\">
                    <i class=\"fa fa-camera-retro fa-1x\"></i>
                        <span>Photo Room</span>
                </a>
                    </li>";} ?>
        </ul>
    </div>
</nav>
<div id="login-form" class="modal_window">
    <form id="login_formic" class="modal_form"  action="autorization_login" method="post">
            <input class="login-input" type="text" name="login" placeholder="login" required>
            <input class="login-input" type="password" name="passwd" placeholder="password" required>
        <button class="custom-btn btn-5" name="do_login" value="OK"><span>Log In</span></button>
            <a id="forgot_href" href="#">Forgot ?</a>

    </form>
</div>

<div id="signUp-form" class="modal_window">
    <form id="signUp_formic" class="modal_form" action="autorization_signup" method="post">
            <input class="login-input" type="text" name="login" placeholder="login" required>
            <input class="login-input" type="email" name="email" placeholder="e-mail" required>
            <input class="login-input" type="password" name="passwd" placeholder="password" required>
            <input class="login-input" type="password" name="passwd1" placeholder="repeat password" required>
            <button class="custom-btn btn-5" name="do_signup" value="OK"><span>Create Account</span></button>
    </form>
</div>

<div id="forgot" class="modal_window">
    <form id="forgot_form" class="modal_form" action="forgot_pass" method="post">
            <input class="login-input" type="email" name="email" placeholder="e-mail" required>
        <button class="custom-btn btn-5" name="do_forgot" value="OK"><span>Send</span></button>
    </form>
</div>

<div id="modify" class="modal_window">
    <form id="modify-form" class="modal_form" action="autorization_modify" method="post">
        <input class="login-input" type="password" name="passwd" placeholder="New Password" required>
        <br/>
        <button class="custom-btn btn-5" name="do_modify_pass" value="OK"><span>Enter</span></button>
    </form>
    <form id="modify-form" class="modal_form" action="autorization_modify" method="post">
        <input class="login-input" type="text" name="email" placeholder="New E-mail" required>
        <br/>
        <button class="custom-btn btn-5" name="do_modify_email" value="OK"><span>Enter</span></button>
    </form>
    <form id="modify-form"  class="modal_form" action="autorization_modify" method="post">
        <input class="login-input" type="text" name="login" placeholder="New Login" required>

        <br/>
        <button class="custom-btn btn-5" name="do_modify_login" value="OK"><span>Enter</span></button>
    </form>
    <form id="modify-form" class="modal_form"  action="autorization_modify" method="post">
        <button class="login-btn" name="do_delete" value="OK" title="Submit">delete</button>
    </form>

</div>
