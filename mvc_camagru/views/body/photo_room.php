<?php
include_once ROOT.'/components/Session.php';

$session = Session::getInstance();
include (ROOT.'/views/layouts/header.php');
?>



<?php if (isset($session->logged_user)):?>

<div class="booth" id="booth">
    <form action="load_photo" method="post" enctype="multipart/form-data">
    <div class="booth" id="booth">
        <img style="width: 400px; height: 300px; position: absolute" id="ph" src="" alt="">
        <video id="video" width="400" height="300" autoplay></video>
        <a onclick="aa()" href="#" id="capture" class="booth-capture-button">Сфотографировать</a>
        <canvas id="canvas" width="480" height="340"></canvas>
        <img src="http://goo.gl/qgUfzX" id="photo" alt="Ваша фотография">
        <img id="for_photo" src="" alt="">
    </div>
    </form>
    <button id="save" class="custom-btn btn-5" ><span>Save</span></button>
    <button id="cancel" class="custom-btn btn-5"><span>Cancel</span></button>
</div>


    <div style="" class="frame_images">
       <figure>
           <img id="korona" style="width: 100px" src="./images/frame/korona.png" alt="">
           <img id="ramka" style="width: 100px" src="./images/frame/shapka.png" alt="">
       </figure>
    </div>


<!--    <script src="/mvc_camagru/templates/js/get_img.js"></script>-->

<?php endif; ?>


<?php
include (ROOT.'/views/layouts/footer.php');
?>
