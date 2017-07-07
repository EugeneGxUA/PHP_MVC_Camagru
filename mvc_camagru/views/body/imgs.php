<?php
include_once(ROOT.'/models/Model_siteProcess.php');
$tmp = new Model_siteProcess($_GET);
?>

<div id="modal_mess">
    <div class="modal_form">
        <img src="<?=$tmp->small_path.$tmp->img[$i]?>" alt="photo">
    </div>
</div>