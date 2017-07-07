<?php

include (ROOT.'/views/layouts/header.php');
include_once(ROOT . '/models/Model_siteProcess.php');

$tmp = new Model_siteProcess($_GET);
?>

<div class="main">

    <div class="gallery">
        <?php
            for($i = $tmp->start_pos; $i < $tmp->end_pos; $i++):
        ?>
                <div class="item">
                    <div>
                        <a data-lightbox="roadtrip" href="<?= $tmp->small_path.$tmp->img[$i]?>">
                            <img style="width: 150px; height: 100px;" class="frontik" src="<?=$tmp->small_path.$tmp->img[$i]?>" alt="photo">
                            <span class="back">Photo #1</span></a>
                    </div>
                </div>
        <?php
            endfor
         ?>

    </div>
</div>
<?php
    if ($tmp->count_pages > 1):
?>
<div class="paginat"><?=$tmp->pagination?>

<?php
    endif
?>

    <br/>
    <br/>
<?php
    if ( isset($session->logged_user) ):
?>

        <div id="photos">
            <form action="load_photo" method="post" enctype="multipart/form-data">
                <input type="hidden" name="size" value="1000000" />
                <div>
                    <input type="file" name="image"/>
                </div>
                <div>
                    <textarea name="text" id="" cols="40" rows="4" placeholder="Some text..."></textarea>
                </div>
                <div>
                    <button class="login-btn" name="do_load" value="OK" title="Submit">Load</button>
                </div>


            </form>
        </div>
<?php
    endif;

include (ROOT.'/views/layouts/footer.php');
?>




