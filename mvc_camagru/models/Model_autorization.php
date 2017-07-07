<?php

/**
 * Created by PhpStorm.
 * User: egaragul
 * Date: 5/6/17
 * Time: 17:15
 */

class Model_autorization
{
    public static function do_login()
    {

       // if ( empty($_SESSION['logged_user']))
        $data = $_POST;

        if ( isset($data['do_login']) )
        {


            $pdo = Db::getConnection();

            // Если ошибок нет - поля заполнены то проверяем сходство логина


                $login = $data['login'];
                $passwd = hash('whirlpool', $data['passwd']);

                $query_login = $pdo->prepare("SELECT * FROM `signup` WHERE login = '$login'");

                $query_login->execute();
                $result_login = $query_login->fetch(PDO::FETCH_ASSOC);

                // Если логин найден то проверяем пароль

                if ( $login == $result_login['login'] )
                {
                    $query_passwd = $pdo->prepare("SELECT * FROM `signup` WHERE password = '$passwd'");
                    $query_passwd->execute();
                    $result_passwd = $query_passwd->fetch(PDO::FETCH_ASSOC);
                    if ( $result_passwd['password'] == $passwd )
                    {

                        // Если пароль найден то проверяем статус активации

                        $query_status = $pdo->prepare("SELECT status FROM `signup` WHERE login='$login'");
                        $query_status->execute();
                        $result_status = $query_status->fetch(PDO::FETCH_ASSOC);
                        if ( $result_status['status'] == "1" )
                        {

                            // если активация віполнена то логиним юзера
                            $session = Session::getInstance();
                            $session->logged_user = $login;

                            echo '<div style="margin-right: auto; margin-left: auto; color: green">Hello '.$login.'</div>';
                            header("Location: http://localhost:8080/mvc_camagru/");
                        }
                        else
                        {
                            echo '<div style="text-align: center; margin-right: auto; margin-left: auto; color: red">Your E-mail not active, Check your E-mail</div>';
                        }
                    }
                    else
                    {
                        echo '<div style="text-align: center; margin-right: auto; margin-left: auto; color: red">Incorect Password</div>';
                    }
                }
                else
                {
                    echo '<div style="text-align: center; margin-right: auto; margin-left: auto; color: red">Incorect Login</div>';
                }

        }
    }

    public static function do_signup()
    {
        $pdo = Db::getConnection();

        $data = $_POST;

        $errors = array();

        if ( isset($data['do_signup']) )
        {
            //registration - check forms
            if (self::Form_Validation($data, $errors))
            {
                // all is OK and registr
                $login = $data['login'];
                $email = $data['email'];
                $passwd = $data['passwd'];
                $query_login = $pdo->prepare("SELECT * FROM `signup` WHERE login = '$login'");
                $query_email = $pdo->prepare("SELECT * FROM `signup` WHERE email = '$email'");

                $query_login->execute();
                $result_login = $query_login->fetchAll();

                $query_email->execute();
                $result_email = $query_email->fetchAll();

                if ($result_login == NULL && $result_email == NULL)
                {
                    $query = $pdo->prepare("INSERT INTO `signup` (login, email, password, status) VALUES (?, ?, ?, ?)");
                    $res = $query->execute([$login, $email, hash('whirlpool', $passwd), 0]);

                    if (self::Send_Email($email, $login, $pdo) == True)
                    {
                        return True;
                    }
                    else
                    {
                        return False;
                    }

                } else
                {
                    echo '<div id="errors" style="text-align: center; margin-right: auto; margin-left: auto; color: red">This Login or E-mail is already used</div>';
                }
            }
        }
    }

    public static function do_logout()
    {
        $session = Session::getInstance();
        $session->destroy();
        header("Location: http://localhost:8080/mvc_camagru/");
    }

    public static function Form_Validation($data, $errors)
    {
        if ( trim($data['login'] === "") )
        {
            $errors[] = 'Enter your login!';
        }
        if ( ($data['passwd'] === "") )
        {
            $errors[] = 'Enter your password!';
        }
        if ( strlen($data['passwd']) <= 3 )
        {
            $errors[] = 'Too short password - please use 8 characters';
        }
        if ( ($data['passwd1'] === "") )
        {
            $errors[] = 'Repeat your password!';
        }
        if ( ($data['passwd1'] !== $data['passwd']) )
        {
            $errors[] = 'Not like password!';
        }
        if( isset($data['email']) )
        {
            if ( !filter_var($data['email'], FILTER_VALIDATE_EMAIL) )
            {
                $errors[] = 'Your E-mail not valid';
            }

            @list($user, $host) = explode("@", $data['email']);
            if ( @!checkdnsrr($host, 'MX') && @!checkdnsrr($host, 'A') )
            {
                $errors[] = 'Bad E-mail server';
            }
        }

        if ( empty($errors) )
        {
            return True;
        }
        else
        {
            echo '<div id="errors" style=" text-align: center; margin-right: auto; margin-left: auto; color: red">'.array_shift($errors).'</div>';
        }
    }

    public static function Send_Email($email, $login, $pdo)
    {

        $login = strtolower($login);

        $activ = $pdo->prepare("SELECT user_id FROM `signup` WHERE login='$login'");
        $activ->execute();

        $id_activ = $activ->fetch(PDO::FETCH_ASSOC);

        $activation = hash('whirlpool', $id_activ['user_id']);

        $subject = "Camagru registration";
        $message = "Здравствуйте! Спасибо за регистрацию на сайте 'Camagru'\nВаш логин: ".$login."\n Для того чтобы войти в свой аккуант его нужно активировать.\n
Чтобы активировать ваш аккаунт, перейдите по ссылке:\n
http://e1r1p8:8080/mvc_camagru/autorization/activation/login-".$login."/act-".$activation."\n\n
С уважением, Camagru Dev";//содержание сообщение

        mail($email, $subject, $message);
        list($user, $host) = explode("@", $email);


        return True;
        /*echo "<p style='text-align: center; margin-right: auto; margin-left: auto; color: green'>На Ваш E-mail выслано письмо с cсылкой, для активации вашего аккуанта. <br /> Проверьте Вашу почту
<a href='$host'>http://$host</a>";
        echo ("<script>window.setTimeout(function(){ window.location = \"http://localhost:8080/mvc_camagru/\"; },4000);</script>");*/


    }

    public static function do_activation($login, $act)
    {
        $pdo = Db::getConnection();

        if ( isset($act) && isset($login) )
        {
            $act = stripcslashes($act);
            $act = htmlspecialchars($act);

            $login = stripcslashes($login);
            $login = htmlspecialchars($login);
        }
        else
        {
            exit("Вы зашли без кода подтверждения");
        }

        $activ = $pdo->prepare("SELECT user_id FROM `signup` WHERE login='$login'");
        $activ->execute();

        $id_activ = $activ->fetch(PDO::FETCH_ASSOC);
        $activation = hash('whirlpool', $id_activ['user_id']);

        if ( $activation === $act )
        {
            $activ = $pdo->prepare("UPDATE `signup` SET status='1' WHERE login = '$login'");
            $activ->execute();
            return True;
        }
        else
        {
            return False;
        }
    }

    public static function do_forgot()
    {
        $pdo = Db::getConnection();
        $session = Session::getInstance();

        $data = $_POST;
        if (!isset($session->logged_user))
        {
            if ( isset($data['do_forgot']) )
            {
                $email = $data['email'];

                $query_email = $pdo->prepare("SELECT * FROM `signup` WHERE email = '$email'");

                $query_email->execute();
                $result_email = $query_email->fetch(PDO::FETCH_ASSOC);

                if ($result_email != NULL)
                {
                    $email = $data['email'];

                    $query_email = $pdo->prepare("SELECT * FROM `signup` WHERE email = '$email'");
                    $query_email->execute();

                    /*$result_email = $query_email->fetchAll();*/

                    if (self::Send_Email_for_passwd($email, $pdo) == TRUE)
                    {
                        return TRUE;
                    }
                }
                else
                {
                    return FALSE;
                }
            }
        }

    }

    public static function Send_Email_for_passwd($email, $pdo)
    {
        $activ = $pdo->prepare("SELECT user_id FROM `signup` WHERE email='$email'");
        $activ->execute();

        $query_login = $pdo->prepare("SELECT login FROM `signup` WHERE email = '$email'");
        $query_login->execute();

        $id_login = $query_login->fetch(PDO::FETCH_ASSOC);

        $login = $id_login['login'];

        $id_activ = $activ->fetch(PDO::FETCH_ASSOC);

        $activation = hash('whirlpool', $id_activ['user_id']);

        $subject = "Camagru reset password";
        $message = "Здравствуйте! С Вашего аккаунта выполнен запрос на восстановление пароля\n Для того чтобы изменить пароль перейдите по ссылке:\n
http://localhost:8080/mvc_camagru/autorization/change_pass/login-".$login."/act-".$activation."\n\n
С уважением, Camagru Dev";//содержание сообщение

        mail($email, $subject, $message);
        list($user, $host) = explode("@", $email);

        return TRUE;
        /*echo "<p style='text-align: center; margin-right: auto; margin-left: auto; color: green'>На Ваш E-mail выслано письмо с cсылкой, для изменения Вашего пароля. <br /> Проверьте Вашу почту
<a href='$host'>http://$host</a>";
        echo ("<script>window.setTimeout(function(){ window.location = \"index.php\"; },4000);</script>");*/

    }

    public static function do_check_user_for_new_pass($login, $act)
    {
        $pdo = Db::getConnection();

        if ( isset($login) && isset($act) )
        {

            $act = stripcslashes($act);
            $act = htmlspecialchars($act);


            $login = stripcslashes($login);
            $login = htmlspecialchars($login);
        }
        else
        {
            exit("Вы зайшли без кода подтверждения");
        }

        $activ = $pdo->prepare("SELECT user_id FROM `signup` WHERE login='$login'");
        $activ->execute();

        $id_activ = $activ->fetch(PDO::FETCH_ASSOC);
        $activation = hash('whirlpool', $id_activ['user_id']);

        if ( $activation == $act )
        {
            header("Location: http://localhost:8080/mvc_camagru/autorization/do_change_pass/");
        }
        else
        {
            echo "<div id=\"modal_mess\">
                <div class=\"modal_form\">
                    <p style='text-align: center; margin-right: auto; margin-left: auto; color: red'>Ошибка, обратитесь к администратору</p>
                </div>
              </div>";
        }
    }

    public static function do_pass_change()
    {
        $pdo = Db::getConnection();

        $data = $_POST;

        if ( isset($data['do_pass_change']) )
        {
            $errors = array();


            if ($data['new_passwd'] !== $data['new_passwd1'])
            {
                $errors[] = "Not equal";
            }
            if (empty($errors))
            {
                $new_passwd = hash('whirlpool', $data['new_passwd']);
                $email = $data['email'];

                $query_email = $pdo->prepare("SELECT * FROM `signup` WHERE email = '$email'");
                $query_email->execute();
                $result_email = $query_email->fetch(PDO::FETCH_ASSOC);
                if ($result_email['email'] == $email)
                {
                    $query_new_passwd = $pdo->prepare("UPDATE `signup` SET password = '$new_passwd' WHERE email = '$email'");
                    $query_new_passwd->execute();
                    return TRUE;
                    /*echo '<div style="text-align: center; color: green">Your password have been changed</div>';*/
                 /*   echo("<script>window.setTimeout(function(){ window.location = \"http://localhost:8080/mvc_camagru/\"; },4000);</script>");*/
                }
            } else
            {
                echo '<div id="errors" style="margin-right: auto; margin-left: auto; color: red">' . array_shift($errors) . '</div>';
            }
        }
    }


    // --       Modify account      --
    public static function do_modify_pass()
    {
        $data = $_POST;

        $pdo = Db::getConnection();

        if ( isset($data['do_modify_pass']) )
        {
            $new_passwd = hash('whirlpool', $data['passwd']);
            $login = $_SESSION['logged_user'];

            $query_new_passwd = $pdo->prepare("UPDATE `signup` SET password = '$new_passwd' WHERE login = '$login'");
            $query_new_passwd->execute();
            echo '<div style="text-align: center; color: green">Your password have been changed</div>';
        }
    }
    public static function do_modify_email()
    {
        $data = $_POST;

        $pdo = Db::getConnection();

        if ( isset($data['do_modify_email']) )
        {
            $new_email = $data['email'];
            $login = $_SESSION['logged_user'];

            $query_new_passwd = $pdo->prepare("UPDATE `signup` SET email = '$new_email' WHERE login = '$login'");
            $query_new_passwd->execute();
            echo '<div style="text-align: center; color: green">Your password have been changed</div>';
        }
    }
    public static function do_modify_login()
    {
        $data = $_POST;

        $pdo = Db::getConnection();

        if ( isset($data['do_modify_login']) )
        {
            $new_login = $data['login'];
            $login = $_SESSION['logged_user'];

            $query_new_passwd = $pdo->prepare("UPDATE `signup` SET login = '$new_login' WHERE login = '$login'");
            $query_new_passwd->execute();
            $_SESSION['logged_user'] = $new_login;
            echo '<div style="text-align: center; color: green">Your login have been changed</div>';
        }
    }
    public static function do_delete_account()
    {
        $data = $_POST;

        $pdo = Db::getConnection();

        if ( isset($data['do_delete']) )
        {
            $login = $_SESSION['logged_user'];

            $query_new_passwd = $pdo->prepare("DELETE FROM `signup` WHERE login = '$login'");
            $query_new_passwd->execute();
            $_SESSION['logged_user'] = "";
            echo '<div style="text-align: center; color: green">Your account have been deleted. We will wait for you againe</div>';
            echo ("<script>window.setTimeout(function(){ window.location = \"http://localhost:8080/mvc_camagru/\"; },4000);</script>");
        }
    }
    // ==       ==============      ==


}