<?php
/**
 * Created by PhpStorm.
 * User: egaragul
 * Date: 5/5/17
 * Time: 20:17
 */

include_once ROOT . '/models/Model_autorization.php';

class AutorizationController
{
    public function actionLogin()
    {
        Model_autorization::do_login();

        require_once ROOT.'/views/main.php';
        return TRUE;
    }

    public function actionSignup()
    {
        if (Model_autorization::do_signup() == TRUE)
        {

            $success = TRUE;
        }
        else
        {
            echo "<div id=\"modal_mess\">
                    <div class=\"modal_form\">
                        <p style='text-align: center; margin-right: auto; margin-left: auto; color: red'>Произошла ошибка обратитесь к администратору</p>
                    </div>
                  </div>";
        }

        require_once ROOT.'/views/main.php';
        echo ("<script>window.setTimeout(function(){ window.location = \"http://localhost:8080/mvc_camagru/\"; },5000);</script>");

        return TRUE;
    }

    public function actionLogout()
    {
        Model_autorization::do_logout();

        require_once ROOT.'/views/main.php';
        return TRUE;
    }

    public function actionActivation($login, $act)
    {
        if ( Model_autorization::do_activation($login, $act) == TRUE)
        {
            $activation = TRUE;
        }
        else
        {
            echo "<div id=\"modal_mess\">
                    <div class=\"modal_form\">
                        <p style='text-align: center; margin-right: auto; margin-left: auto; color: red'>Произошла ошибка обратитесь к администратору</p>
                    </div>
                  </div>";
        }

        require_once ROOT.'/views/main.php';
        echo ("<script>window.setTimeout(function(){ window.location = \"http://localhost:8080/mvc_camagru/\"; },3000);</script>");

        return TRUE;

    }

    public function actionForgot_pass()
    {
        if (Model_autorization::do_forgot() == TRUE)
        {
            $do_forgot = TRUE;
        }
        else
        {
            echo "<div id=\"modal_mess\">
                    <div class=\"modal_form\">
                        <p style='text-align: center; margin-right: auto; margin-left: auto; color: red'>Incorrect E-mail</p>
                    </div>
                  </div>";
        }
        require_once ROOT.'/views/main.php';
        return TRUE;

    }

    public function actionChange_pass($login, $act)
    {
        Model_autorization::do_check_user_for_new_pass($login, $act);
    }

    public function actionDo_change_pass()
    {
       if (Model_autorization::do_pass_change() == TRUE)
       {
           $change_pass = TRUE;
       }
       else
       {
           echo "<div id=\"modal_mess\">
                    <div class=\"modal_form\">
                        <p style='text-align: center; margin-right: auto; margin-left: auto; color: red'>Incorrect E-mail</p>
                    </div>
                  </div>";
       }

        require_once (ROOT.'/views/autorization/change_pass.php');
        return TRUE;
    }

    public function actionModify()
    {
        $session = Session::getInstance();

        if ( isset($session->logged_user) )
        {
            Model_autorization::do_modify_pass();

            Model_autorization::do_modify_email();

            Model_autorization::do_modify_login();

            Model_autorization::do_delete_account();
        }
        require_once ROOT.'/views/main.php';
        return TRUE;
    }
}