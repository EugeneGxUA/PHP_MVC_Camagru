

var signup_href = document.getElementById('signup_href');
var SignUp_Form = document.getElementById('signUp-form');

if (signup_href)
{
    signup_href.onclick = function ()
    {
        if (SignUp_Form.style.display == "none" || !SignUp_Form.style.display)
        {
            SignUp_Form.style.display = "block";
        }
        else
        {
            SignUp_Form.style.display = "none";
        }

    }
}


var login_href = document.getElementById('login_href');
var Login_Form = document.getElementById('login-form');

if (login_href)
{
    login_href.onclick = function ()
    {
        if (Login_Form.style.display == "none" || !Login_Form.style.display)
        {
            Login_Form.style.display = "block";
        }
        else
        {
            Login_Form.style.display = "none";
        }

    }
}


var forgot = document.getElementById('forgot_href');
var Forgot_Form = document.getElementById('forgot');


forgot.onclick = function ()
{

    if (Forgot_Form.style.display == "none" || !Forgot_Form.style.display)
    {
        Login_Form.style.display = "none";
        Forgot_Form.style.display = "block";
    }
    else
    {
        //alert("Hello");
        Forgot_Form.style.display = "none";
    }
}

var modify = document.getElementById('modify_href');
var modify_form = document.getElementById('modify');

if (modify)
{
    modify.onclick = function ()
    {
        if (modify_form.style.display == "none" || !modify_form.style.display)
        {
            modify_form.style.display = "block";
        }
        else
        {
            //alert("Hello");
            modify_form.style.display = "none";
        }
    }
}

var modal = document.getElementById('modal_mess');
if (modal)
{
    window.onload = function ()
    {
        modal.style.display = "block";
    }
}

window.onclick = function(event) {
    if (event.target == SignUp_Form) {
        SignUp_Form.style.display = "none";
    }
    else if (event.target == Login_Form){
        Login_Form.style.display = "none";
    }
    else if (event.target == Forgot_Form){
        Forgot_Form.style.display = "none";
    }
    else if (event.target == modify_form){
        modify_form.style.display = "none";
    }
    else if (event.target == modal){
        modal.style.display = "none";
    }
}

