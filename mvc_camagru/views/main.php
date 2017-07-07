<?php
include_once(ROOT.'/models/Model_site.php');
include_once (ROOT.'/controllers/MainController.php');
$tmp = new Model_site($_GET);
$main = new MainController();

$session = Session::getInstance();

?>

<?php
include (ROOT.'/views/layouts/header.php');
?>

<div class="main">

    <div class="gallery">
        <?php
        for($i = $tmp->start_pos; $i < $tmp->end_pos; $i++):
            ?>
            <div class="item">
                <div>
                    <a  id="modal_photo" >
                        <img id="images" <?php if ( isset($session->logged_user) ): ?> onclick="showImg(this)" <?php endif;?>style="width: 150px; height: 100px;" class="frontik" src="<?=$tmp->small_path.$tmp->img[$i]?>" alt="photo">
                        <span class="back">Photo #<?php echo $i;?></span></a>
                </div>
            </div>
            <?php
        endfor
        ?>

    </div>
</div>
<script src="./templates/js/showImg.js"></script>
<script>
    function figureHandler(e) {
        console.log(e);
    }</script>
<?php
if ($tmp->count_pages > 1):
?>
<div class="paginat"><?=$tmp->pagination?>
</div>
    <?php
    endif
    ?>



    <br/>
    <br/>
    <?php
        if ( isset($session->logged_user) ):
    ?>
            <script>
                function figureHandler(e) {
                    //console.log(e.dataset.id);
                    e.className = "active";
                    if (e.id == 'korona')
                    {
                        var onother = document.getElementById('ramka');
                        onother.className = 'non_active';
                        onother.style.background = 'white';
                    }
                    else if (e.id == 'ramka')
                    {
                        var onother = document.getElementById('korona');
                        onother.className = 'non_active';
                        onother.style.background = 'white';
                    }
                    e.style.background = 'black';
                    var file    = document.querySelector('input[type=file]');
                    file.style.display = 'inline-block';
                }


                function previewFile() {
                    var preview = document.querySelector('.preview');
                    var file    = document.querySelector('input[type=file]').files[0];
                    console.log(file);
                    if ( /\.(jpe?g|png)$/i.test(file.name) ) {
                        var reader = new FileReader();


                        reader.addEventListener("load", function () {
                            preview.src = reader.result;
                        }, false);

                        if (file) {
                            reader.readAsDataURL(file);
                        }
                        activeBtn();
                        var on_photo = document.getElementsByClassName('active');
                        var frame = on_photo[0];
                        var src = frame.src;
                        var capture = document.getElementById('on_photo');
                        capture.src = src;
                        capture.style.width = "150px";
                        capture.style.height = "140px";
                        capture.style.left = "47%";
                        capture.style.position = 'absolute';


                    }
                }

                function activeBtn() {
                    var btn = document.getElementById('load_btn');

                    btn.style.display = 'inline-block';
                    var active = document.getElementsByClassName('active');
                    var dset = active[0].dataset.id;
                    console.log("DSET -> "+dset);
                    btn.onclick = function () {
                        var pic = document.getElementById('picture');
                        var frame = document.getElementById('on_photo');
                        var srcPhoto = pic.src;
                        var srcFrame = frame.src;
                        var tmp = srcFrame.split("mvc_camagru");
                        srcFrame = tmp[1];
                        console.log(srcPhoto);
                        console.log(srcFrame);

                        var ajax = new XMLHttpRequest();
                    ajax.open("POST", "load_photo");
                    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    ajax.send("photo=" + srcPhoto+"&frame=" + srcFrame);
                    }
                }


            </script>

        <div id="photos">
<!--            <form id="file_loading" action="load_photo" method="post" enctype="multipart/form-data">-->
                <input type="hidden" name="size" value="1000000" />
                <div>
                    <input type="file" id="file_image" onchange="previewFile()" name="image" style="display: none"/>
                </div>
<!--                <div>-->
<!--                    <textarea name="text" id="" cols="40" rows="4" placeholder="Some text..."></textarea>-->
<!--                </div>-->
                <div>
                    <button id="load_btn" class="login-btn" name="do_load" value="OK" title="Submit" style="display: none">Load</button>
                </div>
                <img id="picture" class="preview" src="" height="340" width="480" alt="Image preview...">
                <img id="on_photo" src="" alt="">

<!--            </form>-->

            <div style="" class="frame_images">
                <figure>
                    <img id="korona" data-id='1' style="width: 100px" src="./images/frame/korona.png" alt="" onclick="figureHandler(this)">
                    <img id="ramka" data-id='2' style="width: 100px" src="./images/frame/shapka.png" alt="" onclick="figureHandler(this)">
                </figure>
            </div>
        </div>

    <?php
        endif;
    ?>

    <?php if (isset($success)){require_once ROOT . '/views/layouts/email_signup.php';}?>
    <?php if (isset($activation)){require_once ROOT.'/views/layouts/activation.php';}?>
    <?php if (isset($do_forgot)){require_once ROOT.'/views/layouts/forgot.php';}?>
    <?php if (isset($load_ok)){require_once ROOT.'/views/layouts/load_ok.php';}?>








<?php
include (ROOT.'/views/layouts/footer.php')
?>
