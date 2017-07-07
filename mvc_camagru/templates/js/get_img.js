var capture = document.getElementById('capture');

capture.onclick = function () {
    var a = document.getElementById('photo');
    var src = a.src;
    var xmlhttp = new XMLHttpRequest();
    var ph = document.getElementById('ph');
    var srcph = ph.src;
    var nn = srcph.split("mvc_camagru");
    srcph = nn[1];


    xmlhttp.open("POST", "/mvc_camagru/config/get_img.php", true);

    xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xmlhttp.send('photo=' + src + '&src1=' + srcph);

    // xmlhttp.onreadystatechange = function () {
    //     if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
    //
    //     }
    // }
}
