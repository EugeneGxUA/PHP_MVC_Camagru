<?php
include_once ROOT.'/views/layouts/header.php';
?>

<div style="margin-left: auto; margin-right: auto; text-align: center" >
    <form action="" method="post">
        <p>
            <input style="text-align: center" required class="login-input" type="text" name="email" placeholder="E-mail">
        </p>
        <p>
            <input style="text-align: center" required class="login-input" type="password", name="new_passwd" placeholder="Your New Password">
        </p>
        <p>
            <input style="text-align: center" required class="login-input" type="password" name="new_passwd1" placeholder="Repeat New password">
        </p>
        <button class="shape login-btn" type="submit" name="do_pass_change">Change password</button>
    </form>
</div>

<?php if (isset($change_pass)){require_once ROOT.'/views/layouts/change_pass.php';}?>

<?php
include_once ROOT.'/views/layouts/footer.php';
?>